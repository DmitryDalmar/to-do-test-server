<?php

namespace App\Services\Task;

use App\Models\Task\Task;
use App\Services\Saver;

class TaskSaver extends Saver
{
    function __construct($instance = null)
    {
        $this->instance = $instance ?? new Task();
    }

    /**
     * Set relation with user, by auth user
     */
    public function setUser()
    {
        /* @var \App\Models\User\User $authUser */
        $authUser = auth()->user();

        $this->user_id = auth()->user() ? $authUser->id : null;

        return $this;
    }
}
