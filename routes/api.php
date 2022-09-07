<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('/jobs', App\Http\Controllers\Api\JobsController::class);
Route::apiResource('/skills', App\Http\Controllers\Api\SkillsController::class);
Route::apiResource('/candidates', App\Http\Controllers\Api\CandidatesController::class);