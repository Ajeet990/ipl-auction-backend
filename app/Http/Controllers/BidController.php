<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Events\BidPlaced;

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
            $latestBid = Bid::where('player_id', $request->player_id)
                ->orderBy('amount', 'desc')
                ->first();
            if ($latestBid && $request->amount <= $latestBid->amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bid amount must be higher than the current highest bid'
                ], 400);
            }
            $requestData = $request->all();
            $bid = Bid::create($requestData);
            event(new BidPlaced($bid));
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
