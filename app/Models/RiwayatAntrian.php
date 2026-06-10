<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAntrian extends Model
{
    use HasFactory;

    protected $table = 'riwayat_antrian';
    protected $primaryKey = 'idriwayat';

    protected $fillable = [
        'idantrian',
        'nomor_antrian',
        'nama',
        'status',
        'called_at',
        'finished_at',
        'durasi',
    ];

    protected $casts = [
        'called_at' => 'datetime',
        'finished_at' => 'datetime',
        'durasi' => 'integer',
    ];
}
