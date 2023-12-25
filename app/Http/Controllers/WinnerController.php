<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Winner;
// use App\Jobs\IdentifyWinners;


class WinnerController extends Controller
{
    public function showWinner()
    {
        // Get the latest winner
        $winner = Winner::latest('won_at')->first();
        if (!$winner) {
            return response()->json(['error' => 'No winner found']);//, 404);
        }

        return response()->json(['winner' => $winner], 200);
    }
}
