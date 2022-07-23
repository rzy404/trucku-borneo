<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Driver extends Model
{
    use HasFactory, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "tb_driver";
    protected $fillable = [
        'nama',
        'avatar',
        'tgl_lahir',
        'alamat',
        'agama',
        'no_telpon'
    ];

    public $timestamps = false;
}
