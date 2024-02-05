<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PembelianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'id_transaksi' => $this->id_transaksi,
            'no_tiket' => $this->no_tiket,
            'pengunjung' => $this->pengunjung,
            'jumlah_pembelian' => $this->jumlah_pembelian,
            'pembayaran' => $this->pembayaran,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
