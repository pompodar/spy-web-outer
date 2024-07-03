<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameRoom;
use Illuminate\Support\Facades\DB;

class RoundController extends Controller
{
    public function index()
    {
        return Round::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_room_id' => 'required',
            'round_number' => 'required|integer',
            'location' => 'required',
            'end_time' => 'nullable|date',
        ]);

        return Round::create($validatedData);
    }

    public function show($id)
    {
        return Round::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'game_room_id' => 'required',
            'round_number' => 'required|integer',
            'location' => 'required',
            'end_time' => 'nullable|date',
        ]);

        $round = Round::findOrFail($id);
        $round->update($validatedData);

        return $round;
    }

    public function destroy($id)
    {
        $round = Round::findOrFail($id);
        $round->delete();

        return response()->json(['message' => 'Round deleted successfully']);
    }

    public function startNewRound(Request $request, $gameId, $userEmail, $round)
    {
        try {
            DB::beginTransaction();

            $current_user_email = $request->user()?->email ?? $userEmail;
            $location = $this->generateRoundLocation();
            $game = GameRoom::where('id', $gameId)->first();

            if (!$game) {
                return response()->json(['error' => 'Game not found.'], 404);
            }

            $game->update(['round' => $round]);

            $players = $game->players;

            if (count($players) === 0) {
                return response()->json(['error' => 'No players found in the game.'], 400);
            }

            $spyIndex = rand(0, count($players) - 1);
            $spy = $players[$spyIndex];
            $spy->update(['location' => 'Spy']);

            foreach ($players as $player) {
                if ($player->id !== $spy->id) {
                    $player->update(['location' => $location]);
                }
            }

            $players->transform(function ($player) use ($current_user_email) {
                if ($player->email === $current_user_email) {
                    $player->makeVisible('location');
                } else {
                    $player->makeHidden('location');
                }
                return $player;
            });

            DB::commit();

            return response()->json(['players' => $players, 'round' => $round]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error starting new round: ' . $e->getMessage());
            
            return response()->json(['error' => 'An error occurred while starting the new round. Please try again later.'], 500);
        }
    }

    private function generateRoundLocation()
    {
        $locations = ['Казино', 'Космічна станція', 'Цирк', 'Піратський корабель', 'Пляж', 'Кінотеатр', 'Кімната'];

        $randomLocationKey = array_rand($locations);
        $randomLocation = $locations[$randomLocationKey];

        return $randomLocation;
    }

    public function getGameRound($gameId)
    {
        $gameRoom = GameRoom::where('id', $gameId)->first();

        if (!$gameRoom) {
            return response()->json(['error' => 'Game room not found'], 404);
        }

        $round = $gameRoom->round;

        return response()->json(['round' => $round]);

    }

    /**
     * Retrieves the location of a player in a game round.
     *
     * @param int $gameId The ID of the game room.
     * @param string $userEmail The email of the user.
     * @return \Illuminate\Http\JsonResponse The player's location or an error response.
     */
    public function getPlayerLocation($gameId, $userEmail)
    {
        $gameRoom = GameRoom::where('id', $gameId)->first();

        if (!$gameRoom) {
            return response()->json(['error' => 'Game room not found'], 404);
        }

        $round = $gameRoom->round;

        if (!$round) {
            return response()->json(['error' => 'Game round 0'], 404);
        }

        $players = $gameRoom->players;

        if (!$players) {
            return response()->json(['error' => 'No players found'], 404);
        }

        $player = Player::where('email', $userEmail)->first();

        if (!$player) {
            return response()->json(['error' => 'No player found'], 404);
        }

        if ($player->location) {
            return response()->json(['error' => 'Location found'], 404);
        }

        $spy = $players->firstWhere('location', 'Spy');

        if ($spy) {
            $regularLocations = $players->where('location', '!=', 'Spy')
            ->whereNotNull('location')
            ->pluck('location')
            ->unique()
            ->toArray();
            
            if (count($regularLocations) > 0) {
                $player->location = $regularLocations[array_rand($regularLocations)];
            } else {
                $player->location = $this->generateRoundLocation();
            }
        } else {
            $player->location = 'Spy';
        }

        $player->save();

        return response()->json(['playerLocation' => $player->location]);

    }


}
