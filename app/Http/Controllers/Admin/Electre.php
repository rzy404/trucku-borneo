<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Transaksi as transaksi;
use Illuminate\Support\Facades\DB;

class Electre extends Controller
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

    public function Index(Request $request)
    {
        $kriteria = DB::table('tb_kriteria')->get();
        $nilaiBobot = $kriteria->pluck('weight')->toArray();
        $alternatif  = DB::table('tb_transaksi_detail_alternatif')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tb_transaksi')
                    ->whereRaw('tb_transaksi.id = tb_transaksi_detail_alternatif.transaksi')
                    ->where('tb_transaksi.status_penyewaan', 0);
            })
            ->get();
        $nilai_alternatif  = DB::table('tb_alternatif')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tb_transaksi')
                    ->whereRaw('tb_transaksi.id = tb_alternatif.transaksi')
                    ->where('tb_transaksi.status_penyewaan', 0);
            })
            ->get();
        $kolom = count($kriteria);
        $baris = count($alternatif);

        $matriks_bobot = $this->matriks_bobot($kriteria, $kolom);

        $matriks_x = $this->matriks_x($alternatif, $kriteria);
        $matriks_r = $this->matriks_r($matriks_x);
        $matriks_y = $this->matriks_y($matriks_r, $nilaiBobot, $kriteria, $alternatif);
        $solusi_ideal = $this->solusi_ideal($matriks_y, $kriteria, $alternatif, $baris, $kolom);
        $matriks_con = $this->matriks_con($solusi_ideal, $matriks_bobot, $baris, $kolom);
        $matriks_dis = $this->matriks_dis($solusi_ideal, $matriks_bobot, $baris, $kolom);
        $threshold_con = $this->threshold_con($matriks_con, $baris);
        $threshold_dis = $this->threshold_dis($matriks_dis, $baris);
        $dominan_con = $this->dominan_con($matriks_con, $threshold_con, $baris);
        $dominan_dis = $this->dominan_dis($matriks_dis, $threshold_dis, $baris);
        $agregate_matrix = $this->agregate_matrix($dominan_con, $dominan_dis);
        $ekl = $this->ekl($matriks_con, $matriks_dis, $baris, $alternatif);
        $ranking = $this->ranking($ekl);

        return view('backend.admin.electre.index', [
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
            'nilai_alternatif' => $nilai_alternatif,
            'kolom' => $kolom,
            'baris' => $baris,
            'nilaiBobot' => $nilaiBobot,
            'matriks_bobot' => $matriks_bobot,
            'matriks_x' => $matriks_x,
            'matriks_r' => $matriks_r,
            'matriks_y' => $matriks_y,
            'solusi_ideal' => $solusi_ideal,
            'matriks_con' => $matriks_con,
            'matriks_dis' => $matriks_dis,
            'threshold_con' => $threshold_con,
            'threshold_dis' => $threshold_dis,
            'dominan_con' => $dominan_con,
            'dominan_dis' => $dominan_dis,
            'agregate_matrix' => $agregate_matrix,
            'ekl' => $ekl,
            'ranking' => $ranking,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        try {

            $data = transaksi::where('id', $id)->first();
            if ($data->bukti_bayar == null) {
                return redirect()->route('electre.index')->with('error', 'Status gagal diubah');
            } else {
                if ($data->status_penyewaan == 0) {
                    $data->status_penyewaan = 1;
                    $data->save();
                } else {
                    $data->status_penyewaan = 0;
                    $data->save();
                }
            }
            return redirect()->route('electre.index')->with('success', 'Status berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('electre.index')->with('error', 'Status gagal diubah');
        }
    }

    public function matriks_bobot($kriteria)
    {
        $matriks_bobot = [];
        foreach ($kriteria as $kr) {
            array_push($matriks_bobot, $kr->weight);
        }
        return $matriks_bobot;
    }

    public function matriks_x($alternatif, $kriteria)
    {
        $matriks_x = [];
        foreach ($kriteria as $kr) {
            foreach ($alternatif as $alt) {
                $id_alt = $alt->transaksi;
                $id_kr = $kr->id;
                $nilai = DB::table('tb_alternatif')
                    ->where('transaksi', $id_alt)
                    ->where('kriteria', $id_kr)
                    ->first();
                $matriks_x[$id_kr][$id_alt] = $nilai->nilai;
            }
        };

        return $matriks_x;
    }

    public function matriks_r($matriks_x)
    {
        $matriks_r = [];
        foreach ($matriks_x as $key => $value) {
            $jumlah_kuadrat = 0;
            foreach ($value as $key2) {
                $jumlah_kuadrat += pow($key2, 2);
            }
            $akar = sqrt($jumlah_kuadrat);

            foreach ($value as $key3 => $value3) {
                $matriks_r[$key][$key3] = $value3 / $akar;
            }
        }
        return $matriks_r;
    }

    public function matriks_y($matriks_r, $bobot, $kriteria, $alternatif)
    {
        $matriks_y = [];
        foreach ($kriteria as $k) {
            foreach ($alternatif as $a) {
                $bobot = $k->weight;
                $id_alt = $a->transaksi;
                $id_kr = $k->id;

                $nilai_r = $matriks_r[$id_kr][$id_alt];
                $matriks_y[$id_kr][$id_alt] = $nilai_r * $bobot;
            }
        }
        return $matriks_y;
    }

    public function solusi_ideal($y, $kriteria, $alternatif, $baris, $kolom)
    {
        $matriks_baru = [];
        $k = 0;
        $l = 0;
        foreach ($alternatif as $a) {
            foreach ($kriteria as $kr) {
                array_push($matriks_baru, $y[$kr->id][$a->transaksi]);
                $l++;
            }
            $k++;
        }

        if (empty($matriks_baru)) {
            return false;
        }

        $y = [];
        $o = 0;
        for ($i = 0; $i < $baris; $i++) {
            $weight_arr[$i] = [];
            for ($j = 0; $j < $kolom; $j++) {
                $weight_arr[$i][$j] = $matriks_baru[$o];
                $o++;
            }
        }
        return $weight_arr;
    }

    public function matriks_con($y, $bobot, $baris, $kolom)
    {
        $matriks_concordance = [];
        for ($c1 = 0; $c1 < $baris; $c1++) {
            $matriks_concordance[$c1] = [];
            for ($c2 = 0; $c2 < $baris; $c2++) {
                $matriks_concordance[$c1][$c2] = 0;
                $jum_con1 = 0;
                if ($c1 != $c2) {
                    for ($i = 0; $i < $kolom; $i++) {
                        if ($y[$c1][$i] >= $y[$c2][$i]) {
                            $jum_con1 += $bobot[$i];
                        }
                    }
                } else {
                    $jum_con1 = 0;
                }
                $matriks_concordance[$c1][$c2] = $jum_con1;
            }
        }
        return $matriks_concordance;
    }

    public function matriks_dis($y, $bobot, $baris, $kolom)
    {
        $matriks_discordance = [];
        for ($d1 = 0; $d1 < $baris; $d1++) {
            $matriks_discordance[$d1] = [];
            for ($d2 = 0; $d2 < $baris; $d2++) {
                $matriks_discordance[$d1][$d2] = 0;
                $jumlah_dis1 = 0;
                $n_atas = [];
                $n_bawah = [];
                if ($d1 != $d2) {
                    for ($d3 = 0; $d3 < $kolom; $d3++) {
                        if ($y[$d1][$d3] < $y[$d2][$d3]) {
                            array_push($n_atas, (abs($y[$d1][$d3] - $y[$d2][$d3])));
                        }
                        array_push($n_bawah, (abs($y[$d1][$d3] - $y[$d2][$d3])));
                    }
                    if (max($n_bawah) == 0) {
                        $jumlah_dis = 0;
                    } else if ($n_atas == NULL) {
                        $jumlah_dis = 0;
                    } else {
                        $jumlah_dis = max($n_atas) / max($n_bawah);
                    }
                    if (is_nan($jumlah_dis)) {
                        $jumlah_dis1 = 0;
                    } else {
                        $jumlah_dis1 = $jumlah_dis;
                    }
                } else {
                    $jumlah_dis1 = 0;
                }
                $matriks_discordance[$d1][$d2] = $jumlah_dis1;
            }
        }
        return $matriks_discordance;
    }

    public function threshold_con($matriks_concordance, $baris)
    {
        $threshold_concordance = 0;
        $jum_con = 0;
        if ($baris > 1) {
            for ($c1 = 0; $c1 < $baris; $c1++) {
                for ($c2 = 0; $c2 < $baris; $c2++) {
                    if ($c1 != $c2) {
                        $jum_con += $matriks_concordance[$c1][$c2];
                    }
                }
            }
            $threshold_concordance = $jum_con / ($baris * ($baris - 1));
        } else {
            $jum_con = 0;
        }
        return $threshold_concordance;
    }

    public function threshold_dis($matriks_discordance, $baris)
    {
        $threshold_discordance = 0;
        $jum_dis = 0;
        if ($baris > 1) {
            for ($d1 = 0; $d1 < $baris; $d1++) {
                for ($d2 = 0; $d2 < $baris; $d2++) {
                    if ($d1 != $d2) {
                        $jum_dis += $matriks_discordance[$d1][$d2];
                    }
                }
            }
            $threshold_discordance = $jum_dis / ($baris * ($baris - 1));
        } else {
            $jum_dis = 0;
        }
        return $threshold_discordance;
    }

    public function dominan_con($matriks_concordance, $threshold_concordance, $baris)
    {
        $dominan_concordance = [];
        for ($c1 = 0; $c1 < $baris; $c1++) {
            $dominan_concordance[$c1] = [];
            for ($c2 = 0; $c2 < $baris; $c2++) {
                if ($c1 != $c2) {
                    if ($matriks_concordance[$c1][$c2] >= $threshold_concordance) {
                        $dominan_concordance[$c1][$c2] = 1;
                    } else {
                        $dominan_concordance[$c1][$c2] = 0;
                    }
                } else {
                    $dominan_concordance[$c1][$c2] = 0;
                }
            }
        }
        return $dominan_concordance;
    }

    public function dominan_dis($matriks_discordance, $threshold_discordance, $baris)
    {
        $dominan_discordance = [];
        for ($d1 = 0; $d1 < $baris; $d1++) {
            $dominan_discordance[$d1] = [];
            for ($d2 = 0; $d2 < $baris; $d2++) {
                if ($d1 != $d2) {
                    if ($matriks_discordance[$d1][$d2] >= $threshold_discordance) {
                        $dominan_discordance[$d1][$d2] = 1;
                    } else {
                        $dominan_discordance[$d1][$d2] = 0;
                    }
                } else {
                    $dominan_discordance[$d1][$d2] = 0;
                }
            }
        }
        return $dominan_discordance;
    }

    public function agregate_matrix($dominan_concordance, $dominan_discordance)
    {
        $agregate_matrix = [];
        for ($i = 0; $i < sizeof($dominan_concordance); $i++) {
            $agregate_matrix[$i] = [];
            for ($j = 0; $j < sizeof($dominan_concordance); $j++) {
                $agregate_matrix[$i][$j] = $dominan_concordance[$i][$j] * $dominan_discordance[$i][$j];
            }
        }
        return $agregate_matrix;
    }

    public function ekl($matriks_con, $matriks_dis, $baris, $alternatif)
    {
        $ekl = [];
        for ($i = 0; $i < $baris; $i++) {
            $ekl[$i] = 0;
            $jumlah_ekl = 0;
            for ($j = 0; $j < $baris; $j++) {
                if ($i != $j) {
                    $jumlah_ekl += $jumlah_ekl + $matriks_con[$i][$j] - $matriks_dis[$i][$j];
                }
            }
            $ekl[$i] = $jumlah_ekl;
        }

        for ($i = 0; $i < sizeof($ekl); $i++) {
            $alternatif[$i]->nilai_ekl = $ekl[$i];
        }
        return $alternatif;
    }

    public function ranking($ekl)
    {
        $ranking = $ekl->sortByDesc('nilai_ekl')->values();
        return $ranking;
    }
}
