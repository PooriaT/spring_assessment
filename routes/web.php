<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/leaderboard', [LeaderboardController::class, 'index']);
// Route::get('/leaderboard/participants', [LeaderboardController::class, 'getParticipants']);
// Route::get('/leaderboard/participants/{identifier}', [LeaderboardController::class, 'getParticipant']);
// Route::get('/leaderboard/groupbyscore/{score?}', [LeaderboardController::class, 'getGroupedByScore']);
// Route::put('/leaderboard/participants/point/add/{identifier}', [LeaderboardController::class, 'addPoints']);
// Route::put('/leaderboard/participants/point/sub/{identifier}', [LeaderboardController::class, 'subtractPoints']);
// Route::post('/leaderboard/addparticipant', [LeaderboardController::class, 'addParticipant']);
// Route::delete('/leaderboard/deleteparticipant/{identifier}', [LeaderboardController::class, 'deleteParticipant']);