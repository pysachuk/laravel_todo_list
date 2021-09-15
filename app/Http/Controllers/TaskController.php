<?php

namespace App\Http\Controllers;

use App\Events\TaskAdded;
use App\Events\TaskCompleted;
use App\Events\TaskDeleted;
use App\Http\Requests\CompleteTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskCompleted as MailTaskCompleted;

class TaskController extends Controller
{
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this -> taskRepository = $taskRepository;
    }

    public function index()
    {
        return view('task.index');
    }

    public function store(StoreTaskRequest $request)
    {
        if($request -> ajax())
        {
            $task = $this -> taskRepository -> createTask($request);
            if($task)
            {
                event(new TaskAdded(Auth::user() -> name, $task));
                return response() -> json(['OK' => 1]);
            }
        }
        else
            return abort(404);
    }

    public function getTasks()
    {
        $tasks = $this -> taskRepository -> getTasks(5);
        return view('task.tasks', compact('tasks'));
    }

    public function complete(CompleteTaskRequest $request)
    {
        if($request -> ajax())
        {
            $task = $this -> taskRepository -> completeTask($request -> task_id);
            if($task)
            {
                event(new TaskCompleted(Auth::user() -> name, $task));
                Mail::to(env('ADMIN_EMAIL', 'pysachuk@gmail.com'))
                    -> send(new MailTaskCompleted($task, Auth::user()));
                return response() -> json(['OK' => 1]);
            }
        }
        else
            return abort(404);

    }

    public function delete(CompleteTaskRequest $request)
    {
        $task_id = $request -> task_id;
        $task_name = $this -> taskRepository -> getTaskName($task_id);
        if($this -> taskRepository -> deleteTask($task_id))
        {
            event(new TaskDeleted(Auth::user() -> name, $task_name));
            return response() -> json(['OK' => 1]);
        }
    }
}
