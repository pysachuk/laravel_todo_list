<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this -> taskRepository = $taskRepository;
    }

    public function index()
    {
        $tasks = $this -> taskRepository -> getTasks(5);
        return view('task.index', compact('tasks'));
    }

    public function store(StoreTaskRequest $request)
    {
        return $this -> taskRepository -> createTask($request) ?
            redirect() -> back() -> with('success', 'Задача успешно добавлена') :
            abort(404);
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
