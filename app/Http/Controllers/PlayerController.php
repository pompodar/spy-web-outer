<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Models\GameRoom;

class PlayerController extends Controller
{
    public function index()
    {
        return Player::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_room_id' => 'required',
            'email' => 'required',
            'name' => 'required',
            'role' => 'required',
            'score' => 'nullable|integer',
        ]);

        return Player::create($validatedData);
    }

    public function show($id)
    {
        return Player::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'game_room_id' => 'required',
            'email' => 'required',
            'role' => 'required',
            'score' => 'nullable|integer',
        ]);

        $player = Player::findOrFail($id);
        $player->update($validatedData);

        return $player;
    }

    public function destroy($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();

        return response()->json(['message' => 'Player deleted successfully']);
    }

    public function getPlayersByGameCode(Request $request, $gameId, $userEmail)
    {
        $current_user_email = $request->user()?->email ?? $userEmail;

        $gameRoom = GameRoom::where('id', $gameId)->first();

        if (!$gameRoom) {
            return response()->json(['players' => 'No players. Game room not found.']);
        }

        $round = $gameRoom->round;

        // Retrieve players based on the provided game code
        $players = Player::whereHas('gameRoom', function ($query) use ($gameId) {
            $query->where('game_room_id', $gameId);
        })->get();

        $players->transform(function ($player) use ($current_user_email) {
            if ($player->email === $current_user_email) {
                $player->makeVisible('location');
            } else {
                $player->makeHidden('location');
            }
            return $player;
        });

        return response()->json(['players' => $players, 'round' => $round]);

    }

    public function getAdmin(Request $request, $userEmail)
    {
        $player = Player::where('email', $userEmail)->first();
    
        if (!$player) {
            return response()->json(['error' => 'Player not found'], 404);
        }
    
        $isAdmin = $player->role === 'administrator';
    
        return response()->json(['isAdmin' => $isAdmin]);
    }
}
