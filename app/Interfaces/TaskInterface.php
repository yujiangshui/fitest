<?php

namespace Fitest\Interfaces;

interface TaskInterface
{
    public function createTask(array $data, object $user);

    public function updateTask(array $data, object $task);

    /**
     * It is used to mark a task has been finished.
     *
     * @param object $task
     * @return void
     */
    public function markTaskDone(object $task);

    /**
     * It is used to mark a task has been reset to incomplete.
     *
     * @param object $task
     * @return void
     */
    public function markTaskUndone(object $task);
}