<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string|max:255',
        ]);

        if (Auth::user()->role !== 'admin' || Auth::user()->tenant_id !== $request->tenant_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $survey = Survey::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name' => $request->name,
        ]);

        foreach ($request->questions as $question) {
            $survey->questions()->create([
                'question_text' => $question['question_text'],
            ]);
        }

        return response()->json($survey, 201);
    }

    public function list()
    {
        $surveys = Survey::where('tenant_id', Auth::user()->tenant_id)->get();
        return response()->json($surveys);
    }
}
