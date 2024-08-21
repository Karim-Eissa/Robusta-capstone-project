<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $sort = $request->query('sort', 'created_at_desc');
        $orderId = $request->query('order_id');
        $query = Order::with(['items.product', 'address', 'paymentMethod']); // Eager load relationships
        if ($status) {
            $query->where('status', $status);
        }
        if ($orderId) {
            $query->where('id', $orderId);
        }
        switch ($sort) {
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'created_at_desc':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        $orders = $query->paginate(10);
        $ordersCollection = collect($orders->items());
        return response()->json([
            'data' => $ordersCollection->map(function ($order) {
                return [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'status' => $order->status,
                    'total' => $order->total,
                    'items' => $order->items->map(function ($item) {
                        return [
                            'product_id' => $item->product_id,
                            'name' => $item->product->name,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'total' => $item->quantity * $item->price,
                        ];
                    }),
                    'shipping_address' => [
                        'name' => $order->address->name,
                        'address_line1' => $order->address->address_line1,
                        'address_line2' => $order->address->address_line2,
                        'city' => $order->address->city,
                        'state' => $order->address->state,
                        'postal_code' => $order->address->postal_code,
                        'country' => $order->address->country,
                        'phone_number' => $order->address->phone_number,
                    ],
                    'payment_method' => $order->paymentMethod ? [
                        'id' => $order->paymentMethod->id,
                        'name' => $order->paymentMethod->name,
                    ] : null,
                    'created_at' => $order->created_at->toDateTimeString(),
                    'updated_at' => $order->updated_at->toDateTimeString(),
                ];
            }),
            'pagination' => [
                'total' => $orders->total(),
                'count' => $ordersCollection->count(), 
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
            ]
        ]);
    }
}
