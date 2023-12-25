<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderboardUIController extends Controller
{
    public function index()
    {
        return view('leaderboard');
    }
}
