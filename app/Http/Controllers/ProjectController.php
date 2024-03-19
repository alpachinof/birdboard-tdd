<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        return view('projects.index', compact('projects'));
    }
    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required', 'description' => 'required']);

        auth()->user()->projects()->create($data);

        return redirect('/projects');
    }
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }
}
