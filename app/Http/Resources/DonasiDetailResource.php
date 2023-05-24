<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonasiDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'tanggal' => $this->tanggal,
            'gambar' => $this->gambar,
            'status' => $this->status,
            'jumlah_donatur' => $this->whenLoaded('donatur', function () {
                return count($this->donatur);
            }),
            'donatur' => $this->whenLoaded('donatur', function () {
                return collect($this->donatur)->each(function ($donatur) {
                    $donatur->user;
                    return $donatur;
                });
            }),
        ];
    }
}
