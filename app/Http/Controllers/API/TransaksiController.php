<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function transaksiStore(Request $request, $perusahaan)
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
        $biaya = "80000";
        $total = $biaya * $request->jarak_tempuh;

        $data = [
            'perusahaan' => $perusahaan,
            'jarak_tempuh' => $request->jarak_tempuh,
            'jumlah_muatan' => $request->jumlah_muatan,
            'total_biaya' => $total,
            'lama_sewa' => $hari,
            'kriteria' => $request->kriteria
        ];

        $query = DB::table('tb_transaksi_detail_alternatif')->insert([
            'perusahaan' => $data['perusahaan'],
            'jarak_tempuh' => $data['jarak_tempuh'],
            'jumlah_muatan' => $data['jumlah_muatan'],
            'total_biaya' => $data['total_biaya'],
            'lama_sewa' => $data['lama_sewa'],
        ]);


        if ($data['jarak_tempuh'] < 250) {
            $nilai_bobot = 5;
        } else if ($data['jarak_tempuh'] <= 500) {
            $nilai_bobot = 3;
        } else if ($data['jarak_tempuh'] > 500) {
            $nilai_bobot = 2;
        }

        if ($data['jumlah_muatan'] < 600000) {
            $nilai_bobot = 3;
        } else if ($data['jumlah_muatan'] >= 1000000) {
            $nilai_bobot = 4;
        } else if ($data['jumlah_muatan'] > 1000000) {
            $nilai_bobot = 5;
        }

        if ($data['total_biaya'] < 200000000) {
            $nilai_bobot = 2;
        } else if ($data['total_biaya'] >= 500000000) {
            $nilai_bobot = 3;
        } else if ($data['total_biaya'] > 700000000) {
            $nilai_bobot = 4;
        }

        if ($data['lama_sewa'] < 25) {
            $nilai_bobot = 4;
        } else if ($data['lama_sewa'] <= 40) {
            $nilai_bobot = 3;
        } else if ($data['lama_sewa'] > 40) {
            $nilai_bobot = 1;
        }

        $kritt = [
            ["K01" => $data['jarak_tempuh']],
            ["K02" => $data['jumlah_muatan']],
            ["K03" => $data['total_biaya']],
            ["K04" => $data['lama_sewa']],
        ];

        if ($data['kriteria'] == $data['jarak_tempuh']) {
            $kriteria = $kritt[0];
        } elseif ($data['kriteria'] == $data['jumlah_muatan']) {
            $kriteria = $kritt[1];
        } elseif ($data['kriteria'] == $data['total_biaya']) {
            $kriteria = $kritt[2];
        } elseif ($data['kriteria'] == $data['lama_sewa']) {
            $kriteria = $kritt[3];
        }

        $dataAlternatif = [
            [
                'perusahaan' => $data['perusahaan'],
                'kriteria' => $kritt[0],
                'nilai' => $nilai_bobot
            ],
        ];
        foreach ($dataAlternatif as $key => $value) {
            $id[] = DB::table('tb_alternatif')->insertGetId(
                [
                    'perusahaan' => $value['perusahaan'],
                    'kriteria' => $value['kriteria'],
                    'nilai' => $value['nilai']
                ]
            );
        }


        echo json_encode($id[]);

        // foreach ($kritt as $key => $no) {
        //     $input['kriteria'] = $no;
        //     $input['perusahaan '] = $dataAlternatif[$key];
        //     $input['nilai'] = $dataAlternatif[$key];

        //     $test = DB::table('tb_alternatif')->insert($input);
        // }

        return response()->json([
            'success' => true,
            'message' => 'success',
            // 'data' => $test,
        ], 200);
    }

    public function test(Request $request, $perusahaan)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_muatan' => 'required',
        ]);
        $data = [
            'perusahaan' => $perusahaan,
            'jumlah_muatan' => $request->jumlah_muatan = 1000,
        ];

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $data,
        ], 200);
    }
}
