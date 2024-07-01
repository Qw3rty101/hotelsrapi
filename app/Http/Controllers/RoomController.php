<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function show()
    {
        $rooms = Room::all();

        return response()->json($rooms,200);
    }

    public function updateQuantities(Request $request)
    {
        $rooms = $request->input('rooms');

        foreach ($rooms as $roomData) {
            $room = Room::find($roomData['id_room']);
            if ($room) {
                $room->update(['qty' => $roomData['qty']]);
            }
        }

        return response()->json(['message' => 'Quantities updated successfully'], 200);
    }
}
