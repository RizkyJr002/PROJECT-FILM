<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResorce extends JsonResource
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
            'id_cart' => $this->id_cart,
            'hari_kunjungan' => $this->hari_kunjungan,
            'jumlah_beli' => $this->jumlah_beli,
            'status' => $this->status,
            'kode' => $this->kode,
            'total_beli' => $this->total_beli,
            'kategori_tiket' => $this->kategori_tiket,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
