<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Events\PlayerSelected;
use Illuminate\Support\Facades\Log;

class PlayerController extends Controller
{
    public function index()
    {
        try {
            $players = Player::with('bids')->orderBy('id', 'desc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Players retrieved successfully',
                'data' => $players
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve players'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'playing_experience' => 'nullable|integer|min:0',
            'base_price' => 'nullable|numeric|min:0',
            'home_town' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'role' => 'nullable|integer|in:1,2,3,4',
        ]);

        try {
            $player = Player::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Player created successfully',
                'data' => $player
            ], 201);
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return response()->json(['error' => 'Failed to create player'], 500);
        }
    }

    public function markCurrentBidPlayer(Request $request)
    {
        $request->validate([
            'player_id' => 'required|integer|exists:players,id',
        ]);

        try {
            // Reset all players' current_bid_player to 0
            Player::query()->update(['current_bid_player' => 0]);

            // Set the specified player's current_bid_player to 1
            $player = Player::find($request->input('player_id'));
            $player->current_bid_player = 1;
            $player->save();
            Log::info('Broadcasting PlayerSelected event for player ID: ' . $player->id);

            // broadcast(new PlayerSelected($player));
            event(new PlayerSelected($player));

            return response()->json([
                'success' => true,
                'message' => 'Current bid player marked successfully',
                'data' => $player
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to mark current bid player: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to mark current bid player'], 500);
        }
    }   

    public function getCurrentBidPlayer()
    {
        try {
            $player = Player::with('bids')->where('current_bid_player', 1)->first();
            if ($player) {
                return response()->json([
                    'success' => true,
                    'message' => 'Current bid player retrieved successfully',
                    'data' => $player
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No current bid player found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve current bid player'], 500);
        }
    }
}