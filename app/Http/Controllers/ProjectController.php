<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('name', 'ASC')->get();
        return view('project', ['projects' => $projects]);
    }

    public function show($id)
    {
        return view('thisproject' , ['project' => Project::findOrFail($id)]);
    }
}
