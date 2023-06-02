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
            'id' => $this->id,
            'nama' => $this->nama,
            'gambar' => $this->gambar,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'validasi' => $this->whenLoaded('validasi')
        ];
    }
}
