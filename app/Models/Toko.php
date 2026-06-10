<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'toko';
    protected $primaryKey = 'idtoko';

    protected $fillable = [
        'barcode',
        'nama_toko',
        'alamat',
        'latitude',
        'longitude',
        'accuracy',
    ];

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'idtoko', 'idtoko');
    }
}
