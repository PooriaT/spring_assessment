<?php

namespace Tests\Feature;

use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeaderboardTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the "addParticipant" function of the API.
     *
     * This function tests the functionality of adding a participant to the leaderboard.
     *
     * @throws Exception If the API endpoint is not reachable.
     * @return void
    */
    public function testAddParticipant()
    {
        $response = $this->post('/api/leaderboard/addparticipant', [
            'name' => 'John Doe Test Name',
            'age' => 25,
            'points' => 10,
            'address' => '123 Main St',
        ]);
        $response->assertStatus(201)->assertJson(['name' => 'John Doe Test Name']);
    }

    /**
     * This function tests the GET request for the 'Participants' API.
     *
     * @return void
    */
    public function testGetParticipants()
    {
        $response = $this->get('/api/leaderboard/participants');
        $response->assertStatus(200);
    }

    /**
     * This function tests the GET request for the 'Participants' API for a specific participant.
     *
     * @return void
    */
    public function testGetParticipant()
    {
        $post_response = $this->post('/api/leaderboard/addparticipant', [
            'name' => 'John Doe Test Name',
            'age' => 25,
            'points' => 10,
            'address' => '123 Main St',
        ]);
        $response = $this->get("/api/leaderboard/participants/John Doe Test Name");

        $response->assertStatus(200)->assertJson([
            'name' => 'John Doe Test Name',
            'age' => 25,
            'points' => 10,
            'address' => '123 Main St',
        ]);
    }

    /**
     * Test the GET request for the "GroupedByScore" function of the API.
     *
     * @throws Exception if the response status is not 200
    */
    public function testGetGroupedByScore()
    {
        $response = $this->get('/api/leaderboard/groupbyscore');
        $response->assertStatus(200);
    }

    /**
     * Test the functionality of adding points to the leaderboard for a participant.
     *
     * @return void
    */
    public function testAddPoints()
    {
        $post_response = $this->post('/api/leaderboard/addparticipant', [
            'name' => 'John Doe Test Name',
            'age' => 25,
            'points' => 10,
            'address' => '123 Main St',
        ]);
        $response = $this->put("/api/leaderboard/participants/point/add/John Doe Test Name");
        $response->assertStatus(200)->assertJson(['points' => 11]);
    }

    /**
     * Test subtracting points from a participant's leaderboard score.
     *
     * @return void
    */
    public function testSubtractPoints()
    {
        $post_response = $this->post('/api/leaderboard/addparticipant', [
            'name' => 'John Doe Test Name',
            'age' => 25,
            'points' => 10,
            'address' => '123 Main St',
        ]);
        $response = $this->put("/api/leaderboard/participants/point/sub/John Doe Test Name");
        $response->assertStatus(200)->assertJson(['points' => 9]);
    }

    /**
     * Test the deleteParticipant function.
     *
     * @return void
    */
    public function testDeleteParticipant()
    {
        $post_response = $this->post('/api/leaderboard/addparticipant', [
            'name' => 'John Doe Test Name',
            'age' => 25,
            'points' => 10,
            'address' => '123 Main St',
        ]);
        $response = $this->delete("/api/leaderboard/deleteparticipant/John Doe Test Name");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('participants', ['name' => 'John Doe Test Name']);
    }
}