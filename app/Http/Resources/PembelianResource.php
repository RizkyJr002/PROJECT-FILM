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
            'kode' => $this->kode,
            'jumlah_beli' => $this->jumlah_beli,
            'total_beli' => $this->total_beli,
            'kategori_tiket' => $this->kategori_tiket,
            'status' => $this->status,
            'hari_kunjungan' => $this->hari_kunjungan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
