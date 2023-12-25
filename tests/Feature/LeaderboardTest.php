<?php

namespace Tests\Feature;

use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeaderboardTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testGetParticipants()
    {
        // Arrange
        // Participant::factory()->count(5)->create();

        // Act
        $response = $this->get('/api/leaderboard/participants');

        // Assert
        // $response->assertStatus(200)->assertJsonCount(5, 'participants');
        $response->assertStatus(200);
    }

    // public function testGetParticipant()
    // {
    //     // Arrange
    //     // $participant = Participant::factory()->create();

    //     // Act
    //     // $response = $this->get("/api/leaderboard/participants/{$participant->id}");
    //     $response = $this->get("/api/leaderboard/participants/{$id}");
    //     // Assert
    //     $response->assertStatus(200);
    // }

    public function testGetGroupedByScore()
    {
        // Act
        $response = $this->get('/api/leaderboard/groupbyscore');

        // Assert
        $response->assertStatus(200);
    }

    public function testAddPoints()
    {
        // Arrange
        $participant = Participant::factory()->create(['points' => 10]);

        // Act
        $response = $this->put("/api/leaderboard/participants/point/add/{$participant->id}");

        // Assert
        $response->assertStatus(200)->assertJson(['points' => 11]);
    }

    public function testSubtractPoints()
    {
        // Arrange
        $participant = Participant::factory()->create(['points' => 10]);

        // Act
        $response = $this->put("/api/leaderboard/participants/point/sub/{$participant->id}");

        // Assert
        $response->assertStatus(200)->assertJson(['points' => 9]);
    }

    public function testAddParticipant()
    {
        // Act
        $response = $this->post('/api/leaderboard/addparticipant', [
            'name' => 'John Doe',
            'age' => 25,
            'points' => 15,
            'address' => '123 Main St',
        ]);

        // Assert
        $response->assertStatus(201)->assertJson(['name' => 'John Doe']);
    }

    // public function testDeleteParticipant()
    // {
    //     // Arrange
    //     // $participant = Participant::factory()->create();
    //     $id = 3;

    //     // Act
    //     // $response = $this->delete("/api/leaderboard/deleteparticipant/{$participant->id}");
    //     $response = $this->delete("/api/leaderboard/deleteparticipant/{$id}");
    //     // Assert
    //     $response->assertStatus(204);
    //     // $this->assertDatabaseMissing('participants', ['id' => $participant->id]);
    //     $this->assertDatabaseMissing('participants', ['id' => $id]);
    // }
}