<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class UserMutation
{
    public function registerUser($root, array $args, $context, $info)
    {
        $validator = Validator::make($args, [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return [
                'message' => $validator->errors()->first(),
            ];
        }
        $user = User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => Hash::make($args['password']),
            'email_verified_at' => null, 
        ]);
        $token = Str::random(60);
        $user->update(['verification_token' => $token]);
        Mail::to($user->email)->send(new VerifyEmail($token));
        return [
            'user' => $user,
            'message' => 'Registration successful. Please check your email to verify your account.',
        ];
    }
    public function verifyEmail($root, array $args, $context, $info)
    {
        $user = User::where('verification_token', $args['token'])->first();
        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalid or expired token.',
            ];
        }
        $user->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);
        return [
            'success' => true,
            'message' => 'Email successfully verified.',
        ];
    }
}
