<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'jumlah_beli',
        'total_beli',
        'kategori_tiket',
        'status',
        'hari_kunjungan',
        'id_transaksi',
        'kode'
    ];
}
