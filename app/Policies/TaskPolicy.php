<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Task;
use App\Models\User;


class TaskPolicy
{

    public function forceDelete(User $user, Task $task): bool
    {
        return $user->id === $post->user_id
            ? Response::allow()
            :Response::deny('You are not the owner of this Task');
    }
}
