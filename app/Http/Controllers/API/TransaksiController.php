<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Electre as kriteria;

class TransaksiController extends Controller
{
    public function transaksiStore(Request $request, $perusahaan)
    {
        $this->test($request, $perusahaan);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $request->all()
        ], 200);
    }

    private function test(Request $request, $perusahaan)
    {
        $validator = Validator::make($request->all(), [
            'jarak_tempuh' => 'required|string',
            'jumlah_muatan' => 'required|string',
        ]);

        $tgl1 = date_create("2022-11-16");
        $tgl2 = date_create("2022-12-8");
        $diff  = date_diff($tgl1, $tgl2);
        $hari = $diff->days;

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $biaya = "9000000";
        $total = $biaya * $request->jarak_tempuh;

        $data = [
            'perusahaan' => $perusahaan,
            'jarak_tempuh' => $request->jarak_tempuh,
            'jumlah_muatan' => $request->jumlah_muatan,
            'total_biaya' => $total,
            'lama_sewa' => $hari,
            'kriteria' => $request->kriteria,
        ];

        $query = DB::table('tb_transaksi_detail_alternatif')->insert([
            'perusahaan' => $data['perusahaan'],
            'jarak_tempuh' => $data['jarak_tempuh'],
            'jumlah_muatan' => $data['jumlah_muatan'],
            'total_biaya' => $data['total_biaya'],
            'lama_sewa' => $data['lama_sewa'],
        ]);

        $dataKriteria = kriteria::get("id");
        $res_kriteria = [
            $dataKriteria[0]->id,
            $dataKriteria[1]->id,
            $dataKriteria[2]->id,
            $dataKriteria[3]->id,
        ];

        if ($data['jarak_tempuh'] < 250) {
            $bobot[] = 5;
        } else if ($data['jarak_tempuh'] <= 500) {
            $bobot[] = 3;
        } else if ($data['jarak_tempuh'] > 500) {
            $bobot[] = 2;
        }

        if ($data['jumlah_muatan'] < 600000) {
            $bobot[] = 3;
        } else if ($data['jumlah_muatan'] >= 1000000) {
            $bobot[] = 4;
        } else if ($data['jumlah_muatan'] > 1000000) {
            $bobot[] = 5;
        }

        if ($data['total_biaya'] < 200000000) {
            $bobot[] = 2;
        } else if ($data['total_biaya'] >= 500000000) {
            $bobot[] = 3;
        } else if ($data['total_biaya'] > 700000000) {
            $bobot[] = 4;
        }

        if ($data['lama_sewa'] < 25) {
            $bobot[] = 4;
        } else if ($data['lama_sewa'] <= 40) {
            $bobot[] = 3;
        } else if ($data['lama_sewa'] > 40) {
            $bobot[] = 1;
        }
        foreach ($dataKriteria as $key => $value) {
            $savedata[] = DB::table('tb_alternatif')->insertGetId(
                [
                    'perusahaan' => $data['perusahaan'],
                    'kriteria' => $res_kriteria[$key],
                    'nilai' => $bobot[$key],
                ]
            );
        }
    }
}
