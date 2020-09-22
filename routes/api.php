<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Project;
use App\Http\Resources\ProjectResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/api/user/{id}', function($id) {
    return new UserResource(User::find($id));
});

Route::get('/api/project', function() {
    return ProjectResource::collection(Project::all());
});

Route::get('/api/project/{id}', function($id) {
    return new ProjectResource(Project::find($id));
});
