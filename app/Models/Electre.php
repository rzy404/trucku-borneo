<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
}
