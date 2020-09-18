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

        foreach($projects as $project) {
            $amountCollected = 0;
            foreach($project->donations as $donation) {
                $amountCollected = $amountCollected + $donation->amount;
            }
            $project->amountCollected = $amountCollected;
        }
        return view('project', ['projects' => $projects]);
    }

    public function show($id)
    {
        $isOwner = false;
        $donations=[];
        $project = Project::findOrFail($id);
        if(Auth::id() == $project->user_id){
            $isOwner = true;
        }
        $amountCollected = 0;
        $donations = $project->donations;
        foreach($donations as $donation) {
            if($donation->status == 1){
                $amountCollected = $amountCollected + $donation->amount;
            }
        }
        return view('thisproject' , ['project' => $project, 'isOwner' => $isOwner, 'donations' => $donations, 'amountCollected' => $amountCollected/100]);
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
            return redirect('/project');
        } else {
            abort(401);
        }
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
            return redirect('/project');
        } else {
            abort(401);
        }
    }
}
