<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Costumer as costumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tb_costumer',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $costumer = costumer::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $costumer,
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $costumer = costumer::where('email', $request->email)->first();
        if (!$costumer || !Hash::check($request->password, $costumer->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        } elseif ($costumer->status_user !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Non Activation',
            ], 401);
        }
        $costumer->tokens()->delete();
        $token = $costumer->createToken('rzyToken-auth')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $costumer,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $respon = [
            'status' => 'success',
            'msg' => 'Logout successfully',
        ];
        return response()->json($respon, 200);
    }
}
