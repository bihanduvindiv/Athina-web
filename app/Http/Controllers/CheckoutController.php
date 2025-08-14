<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * SIMPLE CHECKOUT PROCESS - Easy to explain in VIVA
     * Step 1: Validate cart items
     * Step 2: Calculate total amount
     * Step 3: Create order in database
     * Step 4: Process payment
     * Step 5: Return success response
     */
    public function processCheckout(Request $request)
    {
        // STEP 1: Validate checkout data
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|string|in:credit_card,paypal,cash_on_delivery'
        ]);

        // STEP 2: Calculate total amount
        $totalAmount = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $itemTotal = $product->price * $item['quantity'];
                $totalAmount += $itemTotal;
                
                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
            }
        }

        // STEP 3: Create order in database
        // For demo purposes, use first product ID and total quantity
        $firstProductId = !empty($orderItems) ? $orderItems[0]['product_id'] : 1;
        $totalQuantity = array_sum(array_column($orderItems, 'quantity'));
        
        $order = Order::create([
            'user_id' => Auth::id() ?? null,
            'product_id' => $firstProductId, // Required by schema
            'quantity' => $totalQuantity,    // Required by schema
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'order_items' => json_encode($orderItems)
        ]);

        // STEP 4: Process payment
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'payment_status' => 'completed' // Simplified for demo
        ]);

        // STEP 5: Update order status
        $order->update([
            'status' => 'confirmed',
            'payment_status' => 'paid'
        ]);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!',
            'order' => [
                'id' => $order->id,
                'total' => $totalAmount,
                'status' => $order->status,
                'payment_id' => $payment->id,
                'payment_status' => $payment->payment_status
            ]
        ]);
    }

    /**
     * GET ORDER DETAILS - Simple method for VIVA
     * Step 1: Find order by ID
     * Step 2: Return order information
     */
    public function getOrder($orderId)
    {
        // STEP 1: Find order in database
        $order = Order::with('payment')->find($orderId);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // STEP 2: Return order details
        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'order_items' => json_decode($order->order_items),
                'created_at' => $order->created_at->format('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * GET ALL ORDERS - Simple method for admin
     */
    public function getAllOrders()
    {
        $orders = Order::with('payment')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'orders' => $orders->map(function($order) {
                return [
                    'id' => $order->id,
                    'customer_name' => $order->customer_name,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s')
                ];
            })
        ]);
    }
}
