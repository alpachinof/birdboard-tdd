<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()->latest('updated_at')->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);

        $project = auth()->user()->projects()->create($data);

        return redirect($project->path());
    }
    public function show(Project $project)
    {
        Gate::authorize('update', $project);

        return view('projects.show', compact('project'));
    }
    public function update(Project $project)
    {
        Gate::authorize('update', $project);

        $project->update([
            'notes' => request('notes')
        ]);

        return redirect($project->path());
    }
}
