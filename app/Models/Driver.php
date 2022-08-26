<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


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

    // protected $dates = "tgl_lahir";

    public $timestamps = false;

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['tgl_lahir'])
            ->format('l, d F Y');
    }
}
