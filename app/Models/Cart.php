<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cart',
        'hari_kunjungan',
        'jumlah_beli',
        'total_beli',
        'kategori_tiket',
        'kode',
    ];
}
