<?php

namespace Fitest\Services;

use Fitest\Interfaces\TaskInterface;
use Fitest\Models\Task;
use Carbon\Carbon;

class TaskService implements TaskInterface
{
    /**
     * Create task
     *
     * @param array $data
     * @param object $user
     * @return void
     */
    public function createTask(array $data, object $user)
    {
        return Task::create([
            'name' => $data['name'],
            'user_id' => $user->id,
        ]);
    }

    /**
     * Update task
     *
     * @param array $data
     * @param object $task
     * @return void
     */
    public function updateTask(array $data, object $task)
    {
        $task->name = $data['name'];
        $task->save();
    }

    /**
     * Mark task has been done.
     *
     * @param object $task
     * @return void
     */
    public function markTaskDone(object $task)
    {
        $task->finished_at = Carbon::now();
        $task->save();
    }

    /**
     * Mark task is undone yet.
     *
     * @param object $task
     * @return void
     */
    public function markTaskUndone(object $task)
    {
        $task->finished_at = null;
        $task->save();
    }
}