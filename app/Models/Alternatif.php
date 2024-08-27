<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi_detail_alternatif';
    protected $primaryKey = 'id';

    protected $fillable = [
        'transaksi',
        'perusahaan',
        'jarak_tempuh',
        'jumlah_muatan',
        'total_biaya',
        'lama_sewa'
    ];
}
