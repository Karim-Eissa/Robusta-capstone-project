<?php
namespace App\GraphQL\Mutations;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartMutation
{
    public function addToCart($root, array $args)
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('User not authenticated.');
        }
        $product = Product::find($args['product_id']);
        if (!$product) {
            throw new \Exception('Product not found.');
        }

        if ($args['quantity'] <= 0) {
            throw new \Exception('Invalid quantity.');
        }
        $cart = Cart::updateOrCreate(
            ['user_id' => $user->id, 'product_id' => $product->id],
            ['quantity' => $args['quantity']]
        );
        return [
            'success' => true,
            'message' => 'Product added to cart successfully.'
        ];
    }
}
