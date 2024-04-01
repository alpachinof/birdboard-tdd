<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $touches = ['project'];

    protected $fillable = [
        'body',
        'completed'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($task) {
            $task->project->recordActivity('created_task');
        });
        static::updated(function ($task) {
            if (!$task->completed) return;
            $task->project->recordActivity('completed_task');
        });
    }

    public function complete()
    {
        $this->update(['completed' => true]);
    }
    public function incomplete()
    {
        $this->update(['completed' => false]);
    }



    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
}
