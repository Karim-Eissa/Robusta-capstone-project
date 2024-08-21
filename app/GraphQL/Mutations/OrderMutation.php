<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB; // 
use App\Mail\OrderConfirmation;

class OrderMutation
{
    public function checkoutOrder($root, array $args)
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception("User not authenticated.");
        }
        if (!$user->email_verified_at) {
            throw new \Exception("Email not verified.");
        }
        $addressId = $args['input']['address_id'];
        $paymentMethodId = $args['input']['payment_method_id'];
        $cartItems = $args['input']['cart_items'];
        $total = 0;
        DB::beginTransaction();
        try {
            foreach ($cartItems as $cartItem) {
                $product = Product::findOrFail($cartItem['product_id']);
                if ($product->stock < $cartItem['quantity']) {
                    throw new \Exception("Product {$product->name} is out of stock.");
                }
            }
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $addressId,
                'payment_method_id' => $paymentMethodId,
                'total' => $total,
                'status' => 'Pending'
            ]);
            foreach ($cartItems as $cartItem) {
                $product = Product::findOrFail($cartItem['product_id']);
                $itemTotal = $product->price * $cartItem['quantity'];
                $product->decrement('stock', $cartItem['quantity']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                    'price' => $product->price
                ]);
                $total += $itemTotal;
            }
            $order->update(['total' => $total]);
            DB::commit();
            Mail::to($user->email)->send(new OrderConfirmation($order));
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

