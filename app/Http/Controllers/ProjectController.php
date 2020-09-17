<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('name', 'ASC')->get();
        return view('project', ['projects' => $projects]);
    }

    public function show($id)
    {
        $isOwner = false;
        $project = Project::findOrFail($id);
        if(Auth::id() == $project->id){
            $isOwner = true;
        }
        return view('thisproject' , ['project' => $project, 'isOwner' => $isOwner]);
    }

    public function store(Request $request)
    {
        if(Auth::check()) {
            $date = date("Y-m-d H:i:s");
            Project::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'date' => strval($date),
                'user_id' => Auth::id(),
            ]);
        }
        var_dump($date);
        return redirect('/project');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        if(Auth::check() && Auth::id() == $project->user_id) {
            return view('project-edit', ['project' => $project]);
        } else {
            return redirect('/project');
        }
    }

    public function update(Request $request, $id)
    {
        $project=Project::findOrFail($id);
        if(Auth::id() == $project->user_id){
            $project->name=$request->name;
            $project->description=$request->description;
            $project->save();
        }

        return redirect('/project');
    }
}
