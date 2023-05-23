<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'kegiatan_donasi_id' => $this->kegiatan_donasi_id,
            'kegiatan_donasi_nama' => $this->kegiatan_donasi_nama,
            'kegiatan_donasi_deskripsi' => $this->kegiatan_donasi_deskripsi,
            'kegiatan_donasi_tanggal' => $this->kegiatan_donasi_tanggal,
            'kegiatan_donasi_gambar' => $this->kegiatan_donasi_gambar,
            'status' => $this->status,
            'jumlah_donatur' => $this->whenLoaded('donatur', function () {
                return count($this->donatur);
            }),
            // 'donatur' => $this->whenLoaded('donatur_detail')
        ];
    }
}
