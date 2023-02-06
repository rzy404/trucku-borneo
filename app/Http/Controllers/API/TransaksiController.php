<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Electre as kriteria;
use App\Models\Transaksi as transaksi;
use App\Models\Perusahaan as costumer;

class TransaksiController extends Controller
{
    public function transaksi(Request $request)
    {
        Validator::make($request->all(), [
            'jenis_truk' => 'required',
            'alamat_asal' => 'required',
            'alamat_tujuan' => 'required',
            'jumlah_muatan' => 'required',
            'tgl_pengambilan' => 'required|date',
            'tgl_pengembalian' => 'required|date',
            'total_biaya' => 'required|numeric',
            'bukti_bayar' => 'nullable',
            'jarak_tempuh' => 'required|numeric',
            'lama_sewa' => 'required|numeric',
        ])->validate();

        $perusahaan = costumer::findOrfail(Auth::user()->perusahaan);
        $id_transaksi = rand(100000, 999999);

        $dataTransaksi = [
            'id' => 'TR' . $id_transaksi,
            'truk' => $request->jenis_truk,
            'perusahaan' => $perusahaan->id_perusahaan,
            'alamat_asal' => $request->alamat_asal,
            'alamat_tujuan' => $request->alamat_tujuan,
            'jumlah_muatan' => $request->jumlah_muatan,
            'tgl_pengambilan' => $request->tgl_pengambilan,
            'tgl_pengembalian' => $request->tgl_pengembalian,
            'total_biaya' => $request->total_biaya,
            'bukti_bayar' => $request->bukti_bayar,
        ];
        $dataTransaksi['tgl_pengambilan'] = date('Y-m-d', strtotime($dataTransaksi['tgl_pengambilan']));
        $dataTransaksi['tgl_pengembalian'] = date('Y-m-d', strtotime($dataTransaksi['tgl_pengembalian']));

        $transaksi = transaksi::create($dataTransaksi);
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $fileName = $transaksi->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('bukti_bayar'), $fileName);
            $transaksi->bukti_bayar = $fileName;
            $transaksi->save();
        }

        $this->HitungNilaiAlternatif(
            $request,
            $dataTransaksi['perusahaan'],
            $dataTransaksi['jumlah_muatan'],
            $dataTransaksi['total_biaya'],
            $request->jarak_tempuh,
            $request->lama_sewa
        );

        return response()->json([
            'message' => 'success',
            'data' => $dataTransaksi,
        ], 200);
    }

    public function uploadBuktiBayar(Request $request)
    {
        Validator::make($request->all(), [
            'id_transaksi' => 'required',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ])->validate();

        $transaksi = transaksi::findOrfail($request->id_transaksi);
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $fileName = $request->id_transaksi . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/bukti_bayar'), $fileName);
            $transaksi->bukti_bayar = $fileName;
            $transaksi->save();
        }

        return response()->json([
            'message' => 'success',
            'data' => $transaksi,
        ], 200);
    }

    private function HitungNilaiAlternatif(Request $request, $perusahaan)
    {
        Validator::make($request->all(), [
            'jarak_tempuh' => 'required',
            'jumlah_muatan' => 'required',
            'lama_sewa' => 'required',
            'total_biaya' => 'required|numeric',
        ]);

        $data = [
            'perusahaan' => $perusahaan,
            'jarak_tempuh' => $request->jarak_tempuh,
            'jumlah_muatan' => $request->jumlah_muatan,
            'total_biaya' => $request->total_biaya,
            'lama_sewa' => $request->lama_sewa,
            // 'kriteria' => $request->kriteria,
        ];

        DB::table('tb_transaksi_detail_alternatif')->insert([
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
        return $savedata;
    }
}
