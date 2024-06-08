<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
// use App\Http\Requests\StoreOrderRequest; // Import validasi request jika diperlukan
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class OrderController extends Controller
{
    // Menampilkan daftar order
    public function index()
    {
        // $orders = Order::all();
        // return response()->json(['orders' => $orders], 200);
        $orders = Order::with('room')->get();
        return response()->json($orders);
    }

    public function getOrders()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    // Menyimpan order baru
    public function order(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'id_room' => 'required|exists:tbl_rooms,id_room',
            'id_facility' => 'required|exists:tbl_facilities,id_facility',
            'price_order' => 'required|numeric',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'order_time' => ['required', 'regex:/^(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$/'],
            'status_order' => 'required|in:Booking,Live,Expired',
        ]);

        // Jika validasi gagal, kirimkan pesan kesalahan
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Memasukkan waktu saat ini sebagai 'order_at'
        $currentTime = now();
        $requestData = $validator->validated();
        $requestData['order_at'] = $currentTime;

        // Simpan order baru
        $order = Order::create($requestData);

        return response()->json(['order' => $order], 201);
    }


    // Menampilkan detail order berdasarkan ID
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return response()->json(['order' => $order], 200);
    }

    // Mengupdate order berdasarkan ID
    // public function update(StoreOrderRequest $request, $id)
    // {
    //     // Memvalidasi input
    //     $validatedData = $request->validated();

    //     // Mengupdate order
    //     $order = Order::findOrFail($id);
    //     $order->update($validatedData);

    //     return response()->json(['order' => $order], 200);
    // }

    // Menghapus order berdasarkan ID
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }

    // Contoh metode tambahan: Menghitung total harga order
    public function calculateTotalPrice(Request $request)
    {
        // Ambil data input
        $checkIn = Carbon::parse($request->input('check_in'));
        $checkOut = Carbon::parse($request->input('check_out'));
        $pricePerNight = $request->input('price_per_night');
        $numberOfNights = $checkIn->diffInDays($checkOut);

        // Hitung total harga order
        $totalPrice = $pricePerNight * $numberOfNights;

        return response()->json(['total_price' => $totalPrice], 200);
    }
}