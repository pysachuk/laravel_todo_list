<?php

namespace App\Http\Controllers;

use App\Events\TaskAdded;
use App\Events\TaskCompleted;
use App\Events\TaskDeleted;
use App\Http\Requests\CompleteTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\GetTasksRequest;
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
        return view('todo_list.index');
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this -> taskRepository -> createTask($request);
        if($task)
        {
            event(new TaskAdded(Auth::user() -> name, $task));
            return response() -> json(['OK' => 1]);
        }
    }

    public function getTasks(GetTasksRequest $request)
    {
        $tasks = $this -> taskRepository -> getTasks(5);
        return view('todo_list.tasks', compact('tasks'));
    }

    public function complete(CompleteTaskRequest $request)
    {
        $task = $this -> taskRepository -> completeTask($request -> task_id);
        if($task)
        {
            event(new TaskCompleted(Auth::user() -> name, $task));
            Mail::to(env('ADMIN_EMAIL'))
                -> send(new MailTaskCompleted($task, Auth::user()));
            return response() -> json(['OK' => 1]);
        }
    }

    public function delete(DeleteTaskRequest $request)
    {
        $task = $this -> taskRepository -> getTask($request -> task_id);
        if($task -> is_done == 0)
            return response() -> json(['error' => 'Задача не выполнена!']);
        if($this -> taskRepository -> deleteTask($request -> task_id))
        {
            event(new TaskDeleted(Auth::user() -> name, $task -> task));
            return response() -> json(['OK' => 1]);
        }
    }
}
