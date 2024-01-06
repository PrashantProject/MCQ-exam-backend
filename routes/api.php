<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionSet;
use App\Http\Controllers\QuestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/new_user',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user',[UserController::class,'user']);

    Route::get('/set',[QuestionSet::class,'Set']);
    Route::post('/set',[QuestionSet::class,'addSet']);
    Route::post('/set_for_user',[QuestionSet::class,'setForUser']);
    Route::put('/set',[QuestionSet::class,'editSet']);
    Route::delete('/set',[QuestionSet::class,'deletSet']);


    Route::post('/question',[QuestionController::class,'addQuestion']);
    Route::put('/question',[QuestionController::class,'editQuestion']);
    Route::delete('/question',[QuestionController::class,'deleteQuestion']);
    


    Route::post('/answer', [ExamController::class, 'addAnswer']);
});



