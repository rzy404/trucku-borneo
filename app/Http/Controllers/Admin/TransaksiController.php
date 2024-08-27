<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Transaksi as transaksi;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('error')) {
                Alert::error(session('error'));
            }

            if (session('errorForm')) {
                $html = "<ul style='list-style: none;'>";
                foreach (session('errorForm') as $error) {
                    $html .= "<li>$error[0]</li>";
                }
                $html .= "</ul>";

                Alert::html('Error during the creation!', $html, 'error');
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $data = transaksi::join('tb_perusahaan_cost', 'tb_transaksi.perusahaan', '=', 'tb_perusahaan_cost.id_perusahaan')
            ->join('tb_jenis_truk', 'tb_transaksi.truk', '=', 'tb_jenis_truk.id')
            ->select(
                'tb_transaksi.id as id_transaksi',
                'tb_perusahaan_cost.nama_perusahaan',
                'tb_jenis_truk.jenis_truk',
                'tb_transaksi.alamat_asal',
                'tb_transaksi.alamat_tujuan',
                'tb_transaksi.jumlah_muatan',
                'tb_transaksi.tgl_pengambilan',
                'tb_transaksi.tgl_pengembalian',
                'tb_transaksi.total_biaya',
                'tb_transaksi.status_penyewaan',
                'tb_transaksi.bukti_bayar'
            )
            ->get();

        return view('backend.admin.master-data.transaksi.index', compact(['data']))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function updateStatus(Request $request, $id)
    {
        try {

            $data = transaksi::where('id', $id)->first();
            if ($data->bukti_bayar == null) {
                return redirect()->route('transaksi.index')->with('error', 'Status gagal diubah');
            } else {
                $status_sewa = $request->input('status_transaksi');
                $data->status_penyewaan = $status_sewa;
                $data->save();
            }
            return redirect()->route('transaksi.index')->with('success', 'Status berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('transaksi.index')->with('error', 'Status gagal diubah');
        }
    }

    public function showBuktiBayar($id)
    {
        $data = transaksi::find($id);
        return response()->json(['path' => asset('images/bukti_bayar/' . $data->bukti_bayar)]);
    }

    public function showDetail($id)
    {
        $data = transaksi::join('tb_perusahaan_cost', 'tb_transaksi.perusahaan', '=', 'tb_perusahaan_cost.id_perusahaan')
            ->join('tb_jenis_truk', 'tb_transaksi.truk', '=', 'tb_jenis_truk.id')
            ->join('tb_transaksi_detail_alternatif', 'tb_transaksi.id', '=', 'tb_transaksi_detail_alternatif.transaksi')
            ->select(
                'tb_transaksi.id as id_transaksi',
                'tb_perusahaan_cost.nama_perusahaan',
                'tb_jenis_truk.jenis_truk',
                'tb_transaksi.alamat_asal',
                'tb_transaksi.alamat_tujuan',
                'tb_transaksi.tgl_pengambilan',
                'tb_transaksi.tgl_pengembalian',
                'tb_transaksi.total_biaya',
                'tb_transaksi.jumlah_muatan',
                'tb_transaksi_detail_alternatif.jarak_tempuh',
                'tb_transaksi_detail_alternatif.lama_sewa',
                'tb_transaksi.status_penyewaan',
                'tb_transaksi.bukti_bayar',
            )
            ->where('tb_transaksi.id', $id)
            ->first();
        return response()->json($data);
    }
}
