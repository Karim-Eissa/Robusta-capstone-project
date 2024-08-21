<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class AuthMutation
{
    public function loginUser($root, array $args)
    {
        $user = User::where('email', $args['email'])->first();
        if (!$user || !Hash::check($args['password'], $user->password)) {
            throw new Exception('Invalid credentials.');
        }
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        return [
            'token' => $token,
            'user' => $user
        ];
    }
}
