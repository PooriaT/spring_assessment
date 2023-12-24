<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaderboardController extends Controller
{
    /**
     * Get the main leaderboard view.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return view('leaderboard');
    // }

    /**
     * Get all participants.
     *
     * @return \Illuminate\Http\Response
     */
    public function getParticipants()
    {
        // $participants = Participant::sortedByPoints()->get();
        $participants = Participant::orderByDesc('points')->get();
        return response()->json($participants);
    }

    /**
     * Get a specific participant by name or ID.
     *
     * @param  string|int  $identifier
     * @return \Illuminate\Http\Response
     */
    public function getParticipant($identifier)
    {
        $participant = Participant::where('name', $identifier)
            ->orWhere('id', $identifier)
            ->first();

        if (!$participant) {
            return response()->json(['error' => 'Participant not found'], 404);
        }

        return response()->json($participant);
    }

    /**
     * Get participants grouped by score.
     *
     * @param  int|null  $score
     * @return \Illuminate\Http\Response
     */
    public function getGroupedByScore($score = null)
    {
        $query = Participant::selectRaw('points, GROUP_CONCAT(name) AS names, AVG(age) AS average_age')
            ->groupBy('points');

        if ($score) {
            $query->where('points', $score);
        }

        $groupedParticipants = $query->orderByDesc('points')->get()->keyBy('points');
        return response()->json($groupedParticipants);
    }

    /**
     * Add points to a participant.
     *
     * @param  string|int  $identifier
     * @return \Illuminate\Http\Response
     */
    public function addPoints($identifier)
    {
        // $participant = $this->find($identifier);
        $participant = Participant::where('name', $identifier)
            ->orWhere('id', $identifier);

        $participant->increment('points');
        return response()->json($participant);
    }

    /**
     * Subtract points from a participant.
     *
     * @param  string|int  $identifier
     * @return \Illuminate\Http\Response
     */
    public function subtractPoints($identifier)
    {
        // $participant = $this->find($identifier);
        $participant = Participant::where('name', $identifier)
            ->orWhere('id', $identifier);

        $participant->decrement('points');
        return response()->json($participant);
    }

    /**
     * Add a new participant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addParticipant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:participants',
            'age' => 'required|integer|min:18',
            'address' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $participant = Participant::create($request->all());
        return response()->json($participant, 201);
    }

    /**
     * Delete a participant.
     *
     * @param  string|int  $identifier
     * @return \Illuminate\Http\Response
     */
    public function deleteParticipant($identifier)
    {
        // $participant = $this->find($identifier);
        $participant = Participant::where('name', $identifier)
            ->orWhere('id', $identifier)
            ->first();
        if($participant) {
            $participant->delete();
            return response()->json(['message' => 'Participant deleted']);
        } else {
            return response()->json(['error' => 'Participant not found'], 404);
        }
    }
}
