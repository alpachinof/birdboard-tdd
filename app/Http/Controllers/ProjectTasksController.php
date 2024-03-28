<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project, Request $request)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }
        $request->validate(['body' => 'required']);

        $project->addTask($request->body);

        return redirect($project->path());
    }
}
