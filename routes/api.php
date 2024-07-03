<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\GameRoomController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\ScoreController;

Route::resource('players', PlayerController::class);

Route::resource('game-rooms', GameRoomController::class);

Route::resource('questions', QuestionController::class);

Route::resource('rounds', RoundController::class);

Route::resource('scores', ScoreController::class);

Route::post('/create-game/{user_name}', [GameRoomController::class, 'create']);

Route::post('/join-game', [GameRoomController::class, 'join']);

Route::get('/game/{gameId}/{userEmail}/players', [PlayerController::class, 'getPlayersByGameCode'])->middleware(['web']);

Route::get('/game/{userEmail}/admin', [PlayerController::class, 'getAdmin']);

Route::delete('/game/{gameId}/{userEmail}/leave', [GameRoomController::class, 'leaveGame']);

Route::post('/games/{gameId}/{userEmail}/{round}/rounds', [RoundController::class, 'startNewRound']);

Route::post('/round/{gameId}/{userEmail}', [RoundController::class, 'getGameRound'])->middleware(['web']);

Route::post('/game/{userEmail}', [GameRoomController::class, 'getUserGame']);

Route::post('/code-game/{inviteGameCode}', [GameRoomController::class, 'codeGame']);

Route::post('/location/{gameId}/{userEmail}', [RoundController::class, 'getPlayerLocation']);



