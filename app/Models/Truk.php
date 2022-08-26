<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Truk extends Model
{
    use HasFactory, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "tb_truck";
    protected $fillable = [
        'no_plat',
        'img_truck',
        'jenis_truck',
        'merek_truck',
        'tahun_buat',
        'warna',
        'dimensi',
        'volume',
        'beban_maks',
        'driver'
    ];

    public $timestamps = false;
}
