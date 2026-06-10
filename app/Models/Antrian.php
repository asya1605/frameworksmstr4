<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrian';
    protected $primaryKey = 'idantrian';

    protected $fillable = [
        'nomor_antrian',
        'nama',
        'status',
        'called_at',
    ];
}
