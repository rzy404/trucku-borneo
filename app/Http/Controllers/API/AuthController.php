<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Truk as truk;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class AuthController extends BaseController
{
    public function index()
    {
        $data = DB::table('tb_truck')
            ->select('tb_truck.*', 'tb_driver.nama as nama_driver')
            ->join('tb_driver', 'tb_driver.id', '=', 'tb_truck.driver')
            ->get();
        return $this->sendResponse($data, 200);
    }
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'nama' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors());
    //     }

    //     $user = Costumer::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password)
    //     ]);

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()
    //         ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    // }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    // // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
