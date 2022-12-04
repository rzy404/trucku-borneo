<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Electre as configElectre;
use App\Models\Perusahaan as alternatif;
use Illuminate\Support\Facades\DB;

class AlgoritmaElectre extends Controller
{
    protected $kolom;
    protected $baris;
    public function __construct($baris = NULL, $kolom = NULL)
    {
        $this->baris = $baris = configElectre::getBaris()->get();
        $this->kolom = $kolom = configElectre::getKolom()->get();
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
        $dataKriteria = configElectre::orderBy('id', 'asc')->get();
        $alternatif = configElectre::getAlternatif();
        $digit = 4;
        $digitPersen = 2;
        $baris = $this->baris[0]->baris;
        $kolom = $this->kolom[0]->kolom;
        $list_alternatif = $this->getMatriks_alternatif();

        return view('admin.electre.index', compact(
            [
                'dataKriteria',
                'kolom',
                'baris',
                'alternatif',
                'digit',
                'digitPersen',
                'list_alternatif'
            ]
        ))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function getData_Kriteria()
    {
        $data = configElectre::orderBy('id', 'asc')->get();
        return $data;
    }

    public function getMatriks_bobot()
    {
        $data = self::getData_Kriteria();
        $matriks_bobot = [];

        foreach ($data as $bobot) {
            array_push($matriks_bobot, $bobot['weight']);
        }
        return $matriks_bobot;
    }

    public function getMatriks_alternatif()
    {
        $data = configElectre::getTransaksiAlternatif();
        $matriks_alternatif = [];

        foreach ($data as $alternatif) {
            array_push($matriks_alternatif, $alternatif->perusahaan);
        }
        return $matriks_alternatif;
    }

    /* STEP 1
	 * Matrix Keputusan (X) / 
	*/
    public function normalization()
    {
        $matiks_x = [];
        $dataKriteria = self::getData_Kriteria();
        $dataAlternatif = configElectre::getAlternatif();
        foreach ($dataKriteria as $k) {
            foreach ($dataAlternatif as $a) {
                $id_alt = $a->perusahaan;
                $id_kri = $k->id;
                $nilai_alternatif = configElectre::getNilaiAlternatif($id_kri, $id_alt);
                if ($nilai_alternatif != null) {
                    $matiks_x[$id_kri][$id_alt] = $nilai_alternatif;
                } else {
                    $matiks_x[$id_kri][$id_alt] = 0;
                }
            }
        }
        return $matiks_x;
    }

    /* STEP 3
	 * Matrix Ternormalisasi (R) / 
	*/
    public function normalization_R()
    {
        $matriks_r = [];
        $dataX = self::normalization();
        foreach ($dataX as $k => $v) {
            //mencari akar kuadrat dari jumlah kuadrat tiap kolom
            $jumlah_kuadrat = 0;
            foreach ($v as $k2) {
                $nilai = $k2[0]->nilai;
                $jumlah_kuadrat += pow($nilai, 2);
            }
            $akar_kuadrat = sqrt($jumlah_kuadrat);

            //mencari hasil pembagian tiap kolom dengan akar kuadrat
            foreach ($v as $k2 => $v2) {
                $nilai = $v2[0]->nilai;
                $matriks_r[$k][$k2] = $nilai / $akar_kuadrat;
            }
        }
        return $matriks_r;
    }

    /* STEP 4
	 * Menentukan Matriks Normalisasi Perbobot (V) / 
	*/
    public function pembobotan()
    {
        $matriks_y = [];
        foreach (self::normalization_R() as $k => $v) {
            $dataKriteria = configElectre::where('id', $k)->first();
            $bobot = $dataKriteria->weight;
            foreach ($v as $k2 => $v2) {
                $matriks_y[$k][$k2] = $v2 * $bobot;
            }
        }
        return $matriks_y;
    }

    /* STEP 5
	 * Solusi Ideal Positif & Negatif / 
	*/
    public function solusi_ideal()
    {
        $matriks_y = self::pembobotan();
        $baris = configElectre::getBaris()->get();
        $kolom = configElectre::getKolom()->get();
        $matriks_baru = [];
        $k = 0;
        $l = 0;
        $dataAlternatif = configElectre::getAlternatif();
        $data = self::getData_Kriteria();

        foreach ($dataAlternatif as $alt) {
            foreach ($data as $kri) {
                $id_alt = $alt->perusahaan;
                $id_kri = $kri->id;
                $bobot = $kri->weight;

                array_push($matriks_baru, $matriks_y[$id_kri][$id_alt]);
                $l++;
            }
            $k++;
        }

        $weight_arr = [];
        $o = 0;
        for ($i = 0; $i < $baris[0]->baris; $i++) {
            for ($j = 0; $j < $kolom[0]->kolom; $j++) {
                $weight_arr[$i][$j] = $matriks_baru[$o];
                $o++;
            }
        }

        return $weight_arr;
    }

    public function tabelConcordance()
    {
        $weight_arr = self::solusi_ideal();
        $baris = configElectre::getBaris()->get();
        $kolom = configElectre::getKolom()->get();
        $con_arr = [];
        $matriks_bobot = self::getMatriks_bobot();

        for ($c1 = 0; $c1 < $baris[0]->baris; $c1++) {
            for ($c2 = 0; $c2 < $baris[0]->baris; $c2++) {
                $jumlah_con1 = 0;
                if ($c1 != $c2) {
                    for ($c3 = 0; $c3 < $kolom[0]->kolom; $c3++) {
                        if ($weight_arr[$c1][$c3] >= $weight_arr[$c2][$c3]) {
                            $jumlah_con1 = $jumlah_con1 + $matriks_bobot[$c3];
                        }
                    }
                } else {
                    $jumlah_con1 = 0;
                }
                $con_arr[$c1][$c2] = $jumlah_con1;
            }
        }
        return $con_arr;
    }

    public function tabelDiscordance()
    {
        $weight_arr = self::solusi_ideal();
        $baris = configElectre::getBaris()->get();
        $kolom = configElectre::getKolom()->get();
        $dis_arr = [];
        for ($d1 = 0; $d1 < $baris[0]->baris; $d1++) {
            for ($d2 = 0; $d2 < $baris[0]->baris; $d2++) {
                $jumlah_dis1 = 0;
                $n_atas = [];
                $n_bawah = [];
                if ($d1 != $d2) {
                    for ($d3 = 0; $d3 < $kolom[0]->kolom; $d3++) {
                        if ($weight_arr[$d1][$d3] < $weight_arr[$d2][$d3]) {
                            array_push($n_atas, (abs($weight_arr[$d1][$d3] - $weight_arr[$d2][$d3])));
                        }
                        array_push($n_bawah, (abs($weight_arr[$d1][$d3] - $weight_arr[$d2][$d3])));
                    }
                    if (max($n_bawah) == 0) {
                        $jumlah_dis = 0;
                    } else if ($n_atas == NULL) {
                        $jumlah_dis = 0;
                    } else {
                        $jumlah_dis = max($n_atas) / max($n_bawah);
                    }
                    // dd($n_bawah);
                    if (is_nan($jumlah_dis)) {
                        $jumlah_dis1 = 0;
                    } else {
                        $jumlah_dis1 = $jumlah_dis;
                    }
                } else {
                    $jumlah_dis1 = 0;
                }
                $dis_arr[$d1][$d2] = $jumlah_dis1;
            }
        }
        return $dis_arr;
    }

    /* STEP 6
	 * Menentukan Matriks Dominan Concordance & Discordance/ 
	*/
    public function thresoldConcordance()
    {
        $baris = configElectre::getBaris()->get();
        $con_arr = self::tabelConcordance();
        $jumlah_threshold_con = 0;
        $threshold_con = 0;
        $tot_con = 0;
        for ($i = 0; $i < $baris[0]->baris; $i++) {
            for ($j = 0; $j < $baris[0]->baris; $j++) {
                if ($i != $j) {
                    $jumlah_threshold_con = $jumlah_threshold_con + $con_arr[$i][$j];
                    $tot_con++;
                }
            }
        }
        $threshold_con = $jumlah_threshold_con / $tot_con;
        return $threshold_con;
    }

    public function thresoldDiscordance()
    {
        $baris = configElectre::getBaris()->get();
        $dis_arr = self::tabelDiscordance();
        $jumlah_threshold_dis = 0;
        $threshold_dis = 0;
        $tot_dis = 0;
        for ($i = 0; $i < $baris[0]->baris; $i++) {
            for ($j = 0; $j < $baris[0]->baris; $j++) {
                if ($i != $j) {
                    $jumlah_threshold_dis = $jumlah_threshold_dis + $dis_arr[$i][$j];
                    $tot_dis++;
                }
            }
        }
        $threshold_dis = $jumlah_threshold_dis / $tot_dis;
        return $threshold_dis;
    }

    public function matriksDominanConcordance()
    {
        $baris = configElectre::getBaris()->get();
        $con_arr = self::tabelConcordance();
        $threshold_con = self::thresoldConcordance();
        $matriks_dominan_con = [];
        for ($i = 0; $i < $baris[0]->baris; $i++) {
            for ($j = 0; $j < $baris[0]->baris; $j++) {
                if ($i != $j) {
                    if ($con_arr[$i][$j] >= $threshold_con) {
                        $matriks_dominan_con[$i][$j] = 1;
                    } else {
                        $matriks_dominan_con[$i][$j] = 0;
                    }
                } else {
                    $matriks_dominan_con[$i][$j] = 0;
                }
            }
        }
        return $matriks_dominan_con;
    }

    public function matriksDominanDiscordance()
    {
        $baris = configElectre::getBaris()->get();
        $dis_arr = self::tabelDiscordance();
        $threshold_dis = self::thresoldDiscordance();
        $matriks_dominan_dis = [];
        for ($i = 0; $i < $baris[0]->baris; $i++) {
            for ($j = 0; $j < $baris[0]->baris; $j++) {
                if ($i != $j) {
                    if ($dis_arr[$i][$j] >= $threshold_dis) {
                        $matriks_dominan_dis[$i][$j] = 1;
                    } else {
                        $matriks_dominan_dis[$i][$j] = 0;
                    }
                } else {
                    $matriks_dominan_dis[$i][$j] = 0;
                }
            }
        }
        return $matriks_dominan_dis;
    }

    /* STEP 7
	 * Menentukan Agregate Dominan Matriks/ 
	*/
    public function agregateDominanMatriks()
    {
        $baris = configElectre::getBaris()->get();
        $matriks_dominan_con = self::matriksDominanConcordance();
        $matriks_dominan_dis = self::matriksDominanDiscordance();
        $agregate_dominan_matriks = [];
        for ($i = 0; $i < $baris[0]->baris; $i++) {
            for ($j = 0; $j < $baris[0]->baris; $j++) {
                if ($i != $j) {
                    if ($matriks_dominan_con[$i][$j] == 1 && $matriks_dominan_dis[$i][$j] == 0) {
                        $agregate_dominan_matriks[$i][$j] = 1;
                    } else {
                        $agregate_dominan_matriks[$i][$j] = 0;
                    }
                } else {
                    $agregate_dominan_matriks[$i][$j] = 0;
                }
            }
        }
        return $agregate_dominan_matriks;
    }

    public function rankingAlternatif()
    {
        $baris = configElectre::getBaris()->get();
        $agregate_dominan_matriks = self::agregateDominanMatriks();
        $tabelConcordance = self::tabelConcordance();
        $tabelDiscordance = self::tabelDiscordance();
        $ranking_alternatif = [];
        for ($i = 0; $i < $baris[0]->baris; $i++) {
            $jumlah = 0;
            for ($j = 0; $j < $baris[0]->baris; $j++) {
                if ($i != $j) {
                    // $jumlah = $jumlah + $agregate_dominan_matriks[$i][$j];
                    $jumlah = $jumlah + $tabelConcordance[$i][$j] - $tabelDiscordance[$i][$j];
                }
            }
            $ranking_alternatif[$i] = $jumlah;
        }
        return $ranking_alternatif;
    }
}
