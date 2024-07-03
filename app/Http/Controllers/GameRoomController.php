<?php

namespace App\Http\Controllers;

use App\Models\GameRoom;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class GameRoomController extends Controller
{
    public function index()
    {
        return GameRoom::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:game_rooms',
        ]);

        return GameRoom::create($validatedData);
    }

    public function show($id)
    {
        return GameRoom::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:game_rooms,code,'.$id,
        ]);

        $gameRoom = GameRoom::findOrFail($id);
        $gameRoom->update($validatedData);

        return $gameRoom;
    }

    public function destroy($id)
    {
        $gameRoom = GameRoom::findOrFail($id);
        $gameRoom->delete();

        return response()->json(['message' => 'Game Room deleted successfully']);
    }

    public function create($user_email, Request $request)
    {
        $existingPlayer = Player::where('email', $user_email)->first();
    
        if ($existingPlayer) {
            $gameRoomCode = $existingPlayer->gameRoom->code;
            
            return response()->json(['error' => 'You are already in a game', 'game_code' => $gameRoomCode], 403);
        }
    
        $user = User::where('email', $user_email)->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        $gameCode = strtoupper(Str::random(6));
    
        DB::beginTransaction();
        try {
            $game = GameRoom::create([
                'code' => $gameCode,
            ]);
    
            $player = Player::create([
                'game_room_id' => $game->id,
                'email' => $user_email,
                'name' => $user->name,
                'role' => 'administrator',
            ]);
    
            DB::commit();
    
            return response()->json(['gameId' => $game->id, 'gameCode' => $game->code, 'player' => $player], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating the game'], 500);
        }
    }

    public function join(Request $request)
    {
        $request->validate([
            'gameCode' => 'required|exists:game_rooms,code',
            'userEmail' => 'required'
        ]);

        $game = GameRoom::where('code', $request->input('gameCode'))->first();

        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        $existingPlayer = Player::where('email', $request->input('userEmail'))->first();

        $user = User::where('email', $request->input('userEmail'))->first();
        
        if (!$existingPlayer) {
            $player = Player::create([
                'game_room_id' => $game->id,
                'email' => $request->input('userEmail'),
                'name' => $user->name,
                'role' => 'guest',
            ]);


            return response()->json(['gameId' => $game->id, 'gameCode' => $game->code, 'existing_player' => true], 201);
        } else {
            if ($existingPlayer->game_room_id == $game->id) {

                // Return the player information
                return response()->json(['gameId' => $game->id, 'gameCode' => $game->code, 'existing_player' => false], 201);
            } else {
                return response()->json(['error' => 'You are still in another game. First leave it and you can join this one.', 'already in another game' => true ], 403);
            }
        }
    }

    public function leaveGame($gameId, $userEmail)
    {
        $player = Player::where('game_room_id', $gameId)->where('email', $userEmail)->first();

        if (!$player) {
            return response()->json(['error' => 'Player not found or not in the game'], 404);
        }

        DB::beginTransaction();
        try {
            $player->delete();

            $remainingPlayers = Player::where('game_room_id', $gameId)->count();

            if ($remainingPlayers === 0) {
                GameRoom::where('id', $gameId)->delete();
                DB::commit();
                return response()->json(['message' => 'Game deleted successfully'], 200);
            }

            if ($player->role == 'administrator') {
                GameRoom::where('id', $gameId)->delete();
                DB::commit();
                return response()->json(['message' => 'Admin left game and it is deleted successfully.'], 200);
            }

            DB::commit();
            return response()->json(['message' => 'Left the game successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while leaving the game'], 500);
        }
    }

    public function getUserGame($user_email, Request $request)
    {
        $player = Player::where('email', $user_email)->first();

        if ($player) {
            $gameRoomId = $player->gameRoom->id;
            $game = GameRoom::where('id', $gameRoomId)->first(); 

            return response()->json(['players' => $game->players], 201);
        } else {
            return response()->json(['players' => []], 404);
        }
    }

    public function codeGame($gameCode, Request $request)
    {
        $game = GameRoom::where('code', $gameCode)->first();

        if ($game) {
            return response()->json(['game' => true], 201);
        } else {
            return response()->json(['game' => false], 201);
        }
    }

}
