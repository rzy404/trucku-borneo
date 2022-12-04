<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transaksi extends Model
{
    use HasFactory, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "tb_transaksi";
    protected $primaryKey = "id";
    protected $fillable = [
        'truk',
        'perusahaan',
        'alamat_asal',
        'alamat_tujuan',
        'jumlah_muatan',
        'tgl_pengambilan',
        'tgl_pengembalian',
        'total_biaya',
        'status_penyewaan',
        'bukti_bayar'
    ];

    public $timestamps = false;
}
