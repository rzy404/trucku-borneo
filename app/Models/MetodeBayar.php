<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class MetodeBayar extends Model
{
    use HasFactory, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "tb_pembayaran";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'metode_bayar',
        'norek',
        'logo',
        'atas_nama'
    ];

    public $timestamps = false;
    public $incrementing = false;
}
