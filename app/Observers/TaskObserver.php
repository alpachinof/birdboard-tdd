<?php

namespace App\Observers;

use App\Models\task;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     */
    public function created(task $task): void
    {
        $task->recordActivity('created_task');
    }

    /**
     * Handle the task "deleted" event.
     */
    public function deleted(task $task): void
    {
        $task->recordActivity('created_task');
    }
}
