<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaksi',
        'no_tiket',
        'pengunjung',
        'jumlah_pembelian',
        'pembayaran',
        'total',
        'status',
        'hari_kunjungan'
    ];
}
