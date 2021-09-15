<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Task;

class TaskCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Экземпляр задачи.
     *
     * @var \App\Models\Task
     */
    public $task;
    /**
     * Экземпляр юзера.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $task, User $user)
    {
        $this -> task = $task;
        $this -> user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@tisto.pp.ua')
            ->view('emails.task_completed');
    }
}
