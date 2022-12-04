<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Perusahaan as perusahaan;
use App\Models\Costumer as costumer;
use Haruncpi\LaravelIdGenerator\IdGenerator as genKode;

class ProfileController extends Controller
{
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
