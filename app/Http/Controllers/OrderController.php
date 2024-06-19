<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
// use App\Http\Requests\StoreOrderRequest; // Import validasi request jika diperlukan
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal
use App\Models\Room;

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
    // public function order(Request $request)
    // {
    //     // Validasi input
    //     $validator = Validator::make($request->all(), [
    //         'id' => 'required|exists:users,id',
    //         'id_room' => 'required|exists:tbl_rooms,id_room',
    //         'id_facility' => 'required|exists:tbl_facilities,id_facility',
    //         'price_order' => 'required|numeric',
    //         'check_in' => 'required|date',
    //         'check_out' => 'required|date|after:check_in',
    //         'order_time' => ['required', 'regex:/^(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$/'],
    //         'status_order' => 'required|in:Booking,Live,Expired',
    //     ]);

    //     // Jika validasi gagal, kirimkan pesan kesalahan
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     // Memasukkan waktu saat ini sebagai 'order_at'
    //     $currentTime = now();
    //     $requestData = $validator->validated();
    //     $requestData['order_at'] = $currentTime;

    //     // Menghitung selisih hari antara check-in dan check-out
    //     $checkIn = Carbon::parse($request->input('check_in'));
    //     $checkOut = Carbon::parse($request->input('check_out'));
    //     $daysDifference = $checkIn->diffInDays($checkOut);

    //     // Menghitung total harga berdasarkan selisih hari
    //     $totalPrice = $request->input('price_order') * $daysDifference;
    //     $requestData['price_order'] = $totalPrice; // Menyimpan total harga ke dalam request data

    //     // Simpan order baru
    //     $order = Order::create($requestData);

    //     return response()->json(['order' => $order], 201);
    // }

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
        $requestData = $validator->validated();
        $requestData['order_at'] = now();

        // Menghitung selisih hari antara check-in dan check-out
        $checkIn = Carbon::parse($request->input('check_in'));
        $checkOut = Carbon::parse($request->input('check_out'));
        $daysDifference = $checkIn->diffInDays($checkOut);

        // Menghitung total harga berdasarkan selisih hari
        $totalPrice = $request->input('price_order') * $daysDifference;
        $requestData['price_order'] = $totalPrice; // Menyimpan total harga ke dalam request data

        $room = Room::where('id_room', $request->id_room);
        $roomData = $room->get();
        if ($roomData[0]->qty <= 0) {
            return response()->json(['error' => 'Kamar tidak tersedia'], 400);
        }
        
        $qty = $roomData[0]->qty - 1;
        
        $room->update([
            'qty' => $qty
        ]);

        $order = Order::create($requestData);

        return response()->json(['order' => $order], 201);
        // return response()->json($room);
    }


    public function showByUser($userId)
    {
        $userOrders = Order::where('id', $userId)->get();
        
        return response()->json(['orders' => $userOrders], 200);
    }


    // Menampilkan detail order berdasarkan ID
    public function show($userId)
    {
        // Temukan pesanan berdasarkan ID pengguna dan ID pesanan
        $order = Order::where('id', $userId)->findOrFail();
        
        return response()->json(['order' => $order], 200);
    }
    

    // Menghapus order berdasarkan ID
    public function destroy($id_order)
    {
        $order = Order::findOrFail($id_order);
        $room = Room::where('id_room', $order->id_room);
        $roomData = $room->get();
        
        $qty = $roomData[0]->qty + 1;
        
        $room->update([
            'qty' => $qty
        ]);

        $order->delete();
        // return response()->json($roomData);
        
        return response()->json(['message' => 'Room Cancel, successfully'], 200);
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

    public function checkStatus($id_order)
    {
        // Mengambil pesanan berdasarkan ID_order
        $order = Order::findOrFail($id_order);

        // Mengambil tanggal hari ini
        $today = Carbon::now()->toDateString();

        // Mengambil tanggal check_out dan order_time dari database
        $checkOutDate = Carbon::parse($order->check_out)->toDateString();

        // Mengambil waktu sekarang
        $currentTime = Carbon::now();

        // Mengubah waktu order_time dari string menjadi objek Carbon
        $orderTime = Carbon::parse($order->order_time);

        // Memeriksa apakah hari ini sesuai dengan tanggal check_out dan waktu persis sama dengan order_time
        if ($today === $checkOutDate && $currentTime->greaterThanOrEqualTo($orderTime)) {
            // Jika benar, ubah status_order menjadi "expired"
            $order->status_order = 'Expired';
            $order->save();
        
            return response()->json(['message' => 'order expired']);
        }

        return response()->json(['message' => 'order belum expired']);
    }

    public function pay($id_order)
    {
        $order = Order::findOrFail($id_order);

        // Ubah status_order menjadi "Live"
        $order->status_order = 'Live';
        $order->save();

        return response()->json(['message' => 'Status menjadi live!'], 200);
    }
}
