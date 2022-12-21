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

    public function updatePerusahaan(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_perusahaan' => 'required|string|max:255',
                'alamat_perusahaan' => 'required|string|max:125'
            ]);

            $costumer = costumer::findOrfail($id);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            if ($costumer->perusahaan == NULL) {
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
                $costumer->perusahaan = $perusahaan->id_perusahaan;
                $costumer->save();
            } else {
                $perusahaan = perusahaan::where('id_perusahaan', $costumer->perusahaan)->update([
                    'nama_perusahaan' => $request->nama_perusahaan,
                    'alamat_perusahaan' => $request->alamat_perusahaan,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $perusahaan,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'error',
            ], 401);
        }
    }
}
