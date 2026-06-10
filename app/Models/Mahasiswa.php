<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';
    protected $primaryKey = 'idmahasiswa';

    protected $fillable = [
        'nim',
        'nama',
        'nfc_serial_number',
    ];

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'mahasiswa_id', 'idmahasiswa');
    }
}
