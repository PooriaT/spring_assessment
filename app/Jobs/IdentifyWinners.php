<?php

namespace App\Jobs;

use App\Models\Winner;
use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IdentifyWinners implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get participants with the highest points
        $participants = Participant::where('points', '=', Participant::max('points'))->get();

        // Check if there's a tie for the highest points
        if ($participants->count() > 1) {
            // If there's a tie, do nothing
            return;
        }

        // If there's a single participant with the highest points, declare them as the winner
        // $winner = new Winner([
        Winner::create([
            'participant_id' => $participants->first()->id,
            'points' => $participants->first()->points,
            'won_at' => now(),
        ]);

        // $winner->save();
    }
}
