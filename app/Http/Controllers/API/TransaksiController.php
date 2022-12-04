<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Electre as kriteria;
use App\Models\Transaksi as transaksi;

class TransaksiController extends Controller
{
    public function transaksi(Request $request, $perusahaan, $jenis_truk)
    {
        Validator::make($request->all(), [
            'alamat_asal' => 'required',
            'alamat_tujuan' => 'required',
            'jumlah_muatan' => 'required',
            'tgl_pengambilan' => 'required|date',
            'tgl_pengembalian' => 'required|date',
            'total_biaya' => 'required|numeric',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ])->validate();

        $dataTransaksi = [
            'truk' => $jenis_truk,
            'perusahaan' => $perusahaan,
            'alamat_asal' => $request->alamat_asal,
            'alamat_tujuan' => $request->alamat_tujuan,
            'jumlah_muatan' => $request->jumlah_muatan,
            'tgl_pengambilan' => $request->tgl_pengambilan,
            'tgl_pengembalian' => $request->tgl_pengembalian,
            'total_biaya' => $request->total_biaya,
            'bukti_bayar' => $request->bukti_bayar,
        ];

        $transaksi = transaksi::create($dataTransaksi);
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $fileName = $transaksi->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('bukti_bayar'), $fileName);
            $transaksi->bukti_bayar = $fileName;
            $transaksi->save();
        }

        $test = $this->HitungNilaiAlternatif(
            $request,
            $perusahaan,
            $dataTransaksi['jumlah_muatan'],
            $dataTransaksi['tgl_pengambilan'],
            $dataTransaksi['tgl_pengembalian'],
            $dataTransaksi['total_biaya']
        );

        return response()->json([
            'message' => 'success',
            'data' => $dataTransaksi,
        ], 200);
    }

    private function HitungJarak($jarak_tempuh)
    {
        $jarak_tempuh = 20;
        return $jarak_tempuh;
    }

    private function HitungNilaiAlternatif(Request $request, $perusahaan)
    {
        Validator::make($request->all(), [
            'jarak_tempuh' => 'required',
            'jumlah_muatan' => 'required',
            'tgl_pengambilan' => 'required|date',
            'tgl_pengembalian' => 'required|date',
            'total_biaya' => 'required|numeric',
        ]);

        $input = [
            'jarak_tempuh' => $this->HitungJarak($request->jarak_tempuh),
            'jumlah_muatan' => $request->jumlah_muatan,
            'tgl_pengambilan' => $request->tgl_pengambilan,
            'tgl_pengembalian' => $request->tgl_pengembalian,
            'total_biaya' => $request->total_biaya,
        ];

        $tgl1 = date_create($input['tgl_pengambilan']);
        $tgl2 = date_create($input['tgl_pengembalian']);
        $diff  = date_diff($tgl1, $tgl2);
        $hari = $diff->days;

        $data = [
            'perusahaan' => $perusahaan,
            'jarak_tempuh' => $this->HitungJarak($request->jarak_tempuh),
            'jumlah_muatan' => $request->jumlah_muatan,
            'total_biaya' => $request->total_biaya,
            'lama_sewa' => $hari,
            'kriteria' => $request->kriteria,
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
