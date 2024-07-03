<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_room_id' => 'required',
            'round_number' => 'required|integer',
            'asker_id' => 'required',
            'question_text' => 'required',
        ]);

        return Question::create($validatedData);
    }

    public function show($id)
    {
        return Question::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'game_room_id' => 'required',
            'round_number' => 'required|integer',
            'asker_id' => 'required',
            'question_text' => 'required',
        ]);

        $question = Question::findOrFail($id);
        $question->update($validatedData);

        return $question;
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json(['message' => 'Question deleted successfully']);
    }
}
