<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/payment', [PaiementController::class, 'index']);
Route::post('/paiement', [PaiementController::class, 'store']);


Route::get('/project', [ProjectController::class, 'index']);
Route::get('/project/{id}', [ProjectController::class, 'show']);
Route::post('/project-create', [ProjectController::class, 'store']);
Route::get('/project-edit/{id}', [ProjectController::class, 'edit']);
Route::post('/project-edit/{id}', [ProjectController::class, 'update']);

Route::get('/logout', [UserController::class, 'logout']);

// Route::get('/api/user/{id}', function($id) {
//     return new UserResource(User::find($id));
// });



Route::post('/donation-create', [DonationController::class, 'store']);


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard', ['user'=>Auth::user()]);
})->name('dashboard');
