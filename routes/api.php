<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\ProjectController;
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

Route::post('register',[StudentController::class,'studentRegister']);
Route::post('login',[StudentController::class,'studentLogin']);

Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('profile',[StudentController::class,'studentProfile']);
    Route::get('logout',[StudentController::class,'studentLogout']);

    Route::post('create-project',[ProjectController::class,'createProject']);
    Route::get('list-project',[ProjectController::class,'listProject']);
    Route::get('list-single-project/{id}',[ProjectController::class,'getSingleProject']);
    Route::delete('delete-project/{id}',[ProjectController::class,'deleteProject']);
});

