<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan as perusahaan;
use App\Models\Costumer as costumer;
use Haruncpi\LaravelIdGenerator\IdGenerator as genKode;

class ProfileController extends Controller
{
    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|string|min:8',
                'new_password' => 'required|string|min:8|different:old_password',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $user = costumer::findOrfail(Auth::user()->id);
            $user->password = bcrypt($request->get('new_password'));
            $user->save();
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Password berhasil diubah',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function changeAvatar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $user = costumer::findOrfail(Auth::user()->id);
            $avatarName = $user->id_costumer . '_avatar' . time() . '.' . $request->avatar->extension();
            if ($user->avatar != 'default.png') {
                $oldAvatar = public_path('images/' . $user->avatar);
                $request->avatar->move(public_path('images/'), $avatarName);
                $user->avatar = $avatarName;
                if (file_exists($oldAvatar)) {
                    @unlink($oldAvatar);
                }
            } else {
                $request->avatar->move(public_path('images/'), $avatarName);
                $user->avatar = $avatarName;
            }
            $user->save();

            return response()->json([
                'message' => 'Avatar berhasil diubah',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'email' => 'required|string|max:125',
                'no_telpon' => 'required|string|max:15',
                'nama_perusahaan' => 'required|string|max:255',
                'alamat_perusahaan' => 'required|string|max:125'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $user = costumer::findOrfail(Auth::user()->id);

            if ($user->perusahaan == NULL) {
                $perusahaan = perusahaan::create([
                    'id_perusahaan' => genKode::generate([
                        'table' => 'tb_perusahaan_cost',
                        'length' => 3,
                        'prefix' => 'A',
                        'field' => 'id_perusahaan',
                    ]),
                    'nama_perusahaan' => $request->nama_perusahaan,
                    'alamat_perusahaan' => $request->alamat_perusahaan,
                ]);
                $user->perusahaan = $perusahaan->id_perusahaan;
                $user->save();
            } else {
                $perusahaan = perusahaan::where('id_perusahaan', $user->perusahaan)->update([
                    'nama_perusahaan' => $request->nama_perusahaan,
                    'alamat_perusahaan' => $request->alamat_perusahaan,
                ]);
            }

            if ($user->email != $request->email) {
                $user->email = $request->email;
                $user->tokens()->delete();
            }

            $user->nama = $request->nama;
            $user->no_telpon = $request->no_telpon;
            $user->save();

            return response()->json([
                'message' => 'Profile berhasil diubah',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
