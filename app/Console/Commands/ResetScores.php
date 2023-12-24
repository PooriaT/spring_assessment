<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Participant;

class ResetScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scores:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all participant scores to 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Resetting scores for all participants...');

        // Retrieve all participants and reset their scores to 0
        Participant::query()->update(['points' => 0]);

        $this->info('Scores reset successfully.');
    }
}
