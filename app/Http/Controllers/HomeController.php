<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function show()
    {
        if (!auth()->check()) {
            return view('welcome');
        } else {
            if (auth()->user()->role == 'admin') {
                return view('dashboard');
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
