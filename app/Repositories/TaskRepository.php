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
        return $task -> save();
    }

    public function completeTask(Task $task)
    {
        $task -> is_done = 1;
        return $task -> save();
    }

    public function deleteTask(Task $task)
    {
        return $task -> delete();
    }
}
