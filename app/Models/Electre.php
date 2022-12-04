<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Electre extends Model
{
    use HasFactory, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "tb_kriteria";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'kriteria',
        'weight',
    ];

    public $timestamps = false;
    public $incrementing = false;

    function getTransaksiAlternatif()
    {
        $query = DB::table('tb_transaksi_detail_alternatif')
            ->select('*')
            ->orderBy('perusahaan', 'asc')
            ->get();
        return $query;
    }

    function getKolom()
    {
        $query = DB::table('tb_kriteria')
            ->select(DB::raw("COUNT(id) as kolom"));
        return $query;
    }

    function getBaris()
    {
        $query = DB::table('tb_transaksi_detail_alternatif')
            ->select(DB::raw("COUNT(id) as baris"));
        return $query;
    }

    function getNilaiAlternatif($kriteria, $alternatif)
    {
        $query = DB::table('tb_alternatif')
            ->select('nilai')
            ->where('kriteria', '=', $kriteria)
            ->where('perusahaan', '=', $alternatif)
            ->get()->toArray();
        return $query;
    }

    function getAlternatif()
    {
        $query = DB::table('tb_alternatif')
            ->select('perusahaan')
            ->groupBy('perusahaan')
            ->get()->toArray();
        return $query;
    }

    function getKriteria()
    {
        $query = DB::table('tb_kriteria')
            ->select('*')
            ->get()->toArray();
        return $query;
    }
}
