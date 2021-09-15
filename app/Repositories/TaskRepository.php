<?php
namespace App\Repositories;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository
{
    public function getTasks($paginate = 10)
    {
        return Task::with('user:id,name')
            -> orderBy('is_done', 'ASC')
            -> orderBy('created_at', 'DESC')
            -> paginate($paginate);
    }

    public function createTask(StoreTaskRequest $request)
    {
        $task = new Task;
        $task -> task = $request -> task;
        $task -> user_id = Auth::id();
        $task -> save();
        return $task;
    }

    public function completeTask($task_id)
    {
        $task = Task::findOrFail($task_id);
        $task -> is_done = 1;
        $task -> save();
        return $task;
    }

    public function deleteTask($task_id)
    {
        $task = Task::findOrFail($task_id);
        return $task -> delete();
    }

    public function getTaskName($task_id)
    {
        $task = Task::findOrFail($task_id);
        return $task -> task;
    }
}
