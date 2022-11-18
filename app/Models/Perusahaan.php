<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Perusahaan extends Model
{
    use HasFactory, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "tb_perusahaan_cost";
    protected $primaryKey = "id_perusahaan";
    protected $fillable = [
        'id_perusahaan',
        'nama_perusahaan',
        'alamat_perusahaan',
    ];

    public $timestamps = false;
    public $incrementing = false;
}
