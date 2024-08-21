<?php declare(strict_types=1);

// app/GraphQL/Mutations/AddressMutation.php

namespace App\GraphQL\Mutations;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressMutation
{
    public function createAddress($root, array $args)
    {
        $user = Auth::user(); 
        if (!$user) {
            throw new \Exception('User is not authenticated.');
        }
        $input = $args['input'];
        $validator = Validator::make($input, [
            'label' => 'required|string',
            'name' => 'required|string',
            'address_line1' => 'required|string',
            'address_line2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
            'phone_number' => 'required|string',
        ]);
        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . $validator->errors()->first());
        }
        return Address::create(array_merge($input, ['user_id' => $user->id]));
    }
}

