<?php

namespace App\Http\Controllers;
use App\Jobs\SendDailyOrdersReport;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function login(Request $request) : JsonResponse{
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
        if(!Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password'], 'is_admin' => 1])){
            return response()->json([
                'message' => 'Invalid credentials or you are not an admin'
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'message' => 'User logged in',
            'user' => $user
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

}
