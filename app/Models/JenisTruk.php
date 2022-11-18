<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class JenisTruk extends Model
{
    use HasFactory, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "tb_jenis_truk";
    protected $fillable = [
        'jenis_truk',
        'dimensi',
        'volume',
        'beban_maks',
        'biaya'
    ];

    public $timestamps = false;
}
