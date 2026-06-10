<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';
    protected $primaryKey = 'idkunjungan';
    public $timestamps = false;

    protected $fillable = [
        'idvendor',
        'idtoko',
        'latitude_vendor',
        'longitude_vendor',
        'accuracy_vendor',
        'jarak',
        'threshold',
        'threshold_efektif',
        'status',
        'waktu_kunjungan',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'idtoko', 'idtoko');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'idvendor', 'id');
    }
}
