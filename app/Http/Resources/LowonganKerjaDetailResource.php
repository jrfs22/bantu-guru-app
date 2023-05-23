<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LowonganKerjaDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lowongan_kerja_id' => $this->lowongan_kerja_id,
            'lowongan_kerja_nama' => $this->lowongan_kerja_nama,
            'lowongan_kerja_file' => $this->lowongan_kerja_file,
            'lowongan_kerja_user_npa_pgri' => $this->lowongan_kerja_user_npa_pgri,
            'lowongan_kerja_view'=> $this->lowongan_kerja_view,
            'user' => $this->whenLoaded('user'),
            'validasi' => $this->whenLoaded('validasi')
        ];
    }
}
