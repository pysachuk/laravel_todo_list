<?php

namespace App\Http\Controllers;

use App\Events\TaskAdded;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Auth;

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
            else
                return abort(404);
        }
    }

    public function getTasks()
    {
        $tasks = $this -> taskRepository -> getTasks(5);
        return view('task.tasks', compact('tasks'));
    }

    public function complete(Task $task)
    {
        if($this -> taskRepository -> completeTask($task))
            return redirect() -> back() -> with('success', 'Задача выполнена.');
    }

    public function delete(Task $task)
    {
        if($this -> taskRepository -> deleteTask($task))
            return redirect() -> back() -> with('info', 'Задача Удалена.');
    }
}
