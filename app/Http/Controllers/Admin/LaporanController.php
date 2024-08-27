<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\App;
use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.admin.laporan.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function print(Request $request)
    {
        if ($request->ajax()) {
            $tgl = $request->input('tgl');
            $status = $request->input('status');

            if ($tgl == "" || $status == "") {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Silahkan isi tanggal dan status terlebih dahulu!',
                ]);
            }

            // $data = Transaksi::where('status_penyewaan', $status)
            //     ->whereDate('tgl_transaksi', $tgl)
            //     ->get();

            $data = Transaksi::select('tb_transaksi.id', 'tb_jenis_truk.jenis_truk', 'tb_perusahaan_cost.nama_perusahaan', 'tb_transaksi.status_penyewaan', 'tb_transaksi.tgl_transaksi', 'tb_transaksi.total_biaya')
                ->join('tb_jenis_truk', 'tb_transaksi.truk', '=', 'tb_jenis_truk.id')
                ->join('tb_perusahaan_cost', 'tb_transaksi.perusahaan', '=', 'tb_perusahaan_cost.id_perusahaan')
                ->where('tb_transaksi.status_penyewaan', $status)
                ->whereDate('tb_transaksi.tgl_transaksi', $tgl)
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan!',
                ]);
            }

            $title = 'Laporan Transaksi ' . date('d-m-Y', strtotime($tgl));

            $view = view('backend.admin.laporan.print', compact('data', 'title'))->render();

            return response()->json([
                'status' => 'success',
                'view' => $view,
                'title' => $title,
            ]);
        }
    }
}
