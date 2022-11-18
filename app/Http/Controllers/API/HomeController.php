<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Costumer as costumer;
use App\Models\Truk as truk;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function GetProfile(Request $request)
    {
        $data = $request->user();
        $data = DB::table('tb_costumer')
            ->select('*')
            ->leftJoin('tb_perusahaan_cost', 'tb_perusahaan_cost.id_perusahaan', '=', 'tb_costumer.perusahaan')
            ->where('tb_costumer.id', $request->user()->id)
            ->first();
        return response()->json($data);
    }

    public function GetTruck()
    {
        $data = truk::all();
        return response()->json(['message' => 'Success', 'data' => $data]);
    }
}
