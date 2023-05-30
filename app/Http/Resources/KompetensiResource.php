<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KompetensiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'tipe' => $this->tipe,
            'max_peserta' => $this->max_peserta,
            'deskripsi' => $this->deskripsi,
            'poster' => $this->poster,
            'jumlah_peserta' => $this->whenLoaded('peserta', function () {
                return count($this->peserta);
            })
        ];
    }
}
