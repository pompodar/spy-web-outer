<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index()
    {
        return Score::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_room_id' => 'required',
            'player_id' => 'required',
            'round_number' => 'required|integer',
            'score' => 'required|integer',
        ]);

        return Score::create($validatedData);
    }

    public function show($id)
    {
        return Score::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'game_room_id' => 'required',
            'player_id' => 'required',
            'round_number' => 'required|integer',
            'score' => 'required|integer',
        ]);

        $score = Score::findOrFail($id);
        $score->update($validatedData);

        return $score;
    }

    public function destroy($id)
    {
        $score = Score::findOrFail($id);
        $score->delete();

        return response()->json(['message' => 'Score deleted successfully']);
    }
}
