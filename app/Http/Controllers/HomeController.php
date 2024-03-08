<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function show()
    {
        if (!auth()->check()) {
            return view('welcome');
        } else {
            if (auth()->user()->role == 'admin') {
                $teamSize = User::count();
                $averageSurveysAnswered = Survey::averageAnsweredRate();
                $numberOfSurveys = Survey::count();

                return view('dashboard', compact('teamSize', 'averageSurveysAnswered', 'numberOfSurveys'));
            } else {
                return redirect()->route('surveys');
            }
        }
    }

    public function getIsAdminProperty()
    {
        return Auth::user()->role === 'admin';
    }
}
