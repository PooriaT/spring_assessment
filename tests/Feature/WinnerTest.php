<?php

namespace Tests\Feature;

use App\Models\Winner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class WinnerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // public function testShowWinner()
    // {
    //     // // Arrange
    //     // Winner::factory()->create(['points' => 20]);

    //     // Act
    //     $response = $this->get('/api/leaderboard/winner');

    //     // Assert
    //     // $response->assertStatus(200)->assertJsonStructure(['winner' => ['participant_id', 'points', 'won_at']]);
    //     $response->assertStatus(200);
    // }
}
