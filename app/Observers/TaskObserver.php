<?php

namespace Fitest\Observers;

use Fitest\Models\Task;
use Illuminate\Support\Facades\Auth;
use Fitest\Services\LogService;

class TaskObserver
{
    protected $logService;

    public function __construct(LogService $logService) 
    {
        $this->user = Auth::user();
        $this->logService = $logService;
    }

    /**
     * Handle the task "created" event.
     *
     * @param  \Fitest\odels\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $this->user = empty($this->user) ? ($task->user) : $this->user;
        $desc = 'task ' . $task->id . ' is created by user '. $this->user->id;
        $this->logService->createTaskLog($this->user, $desc);
    }

    /**
     * Handle the task "updated" event.
     * The updated events include updated tasks, done tasks, undone tasks.
     *
     * @param  \Fitest\odels\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        if ($task->isDirty('finished_at')) {
            $desc = $task->finished_at 
            ? ('task ' . $task->id . ' is done by user '. $this->user->id)
            : ('task ' . $task->id . ' is undone by user '. $this->user->id);
        } else {
            $desc = 'task ' . $task->id . ' is updated by user '. $this->user->id;
        }

        $this->logService->createTaskLog($this->user, $desc);
    }

    /**
     * Handle the task "deleted" event.
     *
     * @param  \Fitest\odels\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $desc = 'task ' . $task->id . ' is deleted by user '. $this->user->id;
        $this->logService->createTaskLog($this->user, $desc);
    }

    /**
     * Handle the task "restored" event.
     *
     * @param  \Fitest\odels\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the task "force deleted" event.
     *
     * @param  \Fitest\odels\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
