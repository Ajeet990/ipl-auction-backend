<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;

class BidController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'player_id' => 'required|integer|exists:players,id',
            'amount' => 'required|numeric|min:0',
            'bidder_name' => 'nullable|string|max:255',
        ]);

        try {
            $bid = Bid::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Bid created successfully',
                'data' => $bid
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create bid'], 500);
        }
    }
}
