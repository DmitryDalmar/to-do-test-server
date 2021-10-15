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
}
