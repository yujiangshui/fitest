<?php

namespace Fitest\Policies;

use Fitest\Models\User;
use Fitest\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if a user can operate a task.
     * Return $user->id === $task->user_id;  //Equal to "return $user->is($task->user);
     * Check ($user->id == 1), it is similar with check admin. If the admin does this operation, it always returns true.
     * If I have enough time, I will add an role_permissions plugins to controll different roles.
     *
     * @param \Fitest\Models\User $user
     * @param \Fitest\Models\Task $task
     * @return bool
     */
    public function match(User $user, Task $task)
    {
        return ($user->id == 1) ? true : ($user->id === $task->user_id);
    }
}
