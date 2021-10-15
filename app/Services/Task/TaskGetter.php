<?php

namespace App\Services\Task;

use App\Models\Task\Task;
use App\Services\Getter;

class TaskGetter extends Getter
{
    public function __construct()
    {
        $this->query = Task::with(['media']);
    }
}
