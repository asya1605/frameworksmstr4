<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $primaryKey = 'id_barang'; //  penting

    public $incrementing = false; // karena bukan auto increment int

    protected $keyType = 'string'; // karena varchar

    public $timestamps = false; // karena pakai kolom timestamp sendiri

    protected $fillable = [
        'nama',
        'harga'
    ];
}