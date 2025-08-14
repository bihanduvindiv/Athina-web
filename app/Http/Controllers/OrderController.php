<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{

  
    public function __construct()
    {
        // Require login for all order actions
        $this->middleware('auth');
    }

    // List all orders for a user or all orders for admin
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->role === 'admin') {
            // Admin sees all orders
            return response()->json(Order::all());
        }
        // Regular user sees only their orders
        return response()->json(Order::where('user_id', $user->id)->get());
    }

    // Create a new order (only for logged-in users)
    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'payment_status' => 'pending',
        ]);
        return response()->json($order, 201);
    }

    // Fake payment gateway: mark order as paid
    public function pay($id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = 'paid';
        $order->save();
        return response()->json(['message' => 'Payment successful', 'order' => $order]);
    }
}
