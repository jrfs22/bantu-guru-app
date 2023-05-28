<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonaturResource extends JsonResource
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
            'catatan' => $this->catatan,
            'nominal' => $this->nominal,
            'bukti_pembayaran' => $this->bukti_pembayaran,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'donasi_id' => $this->donasi_id,
            'donasi' => $this->whenLoaded('donasi')
        ];
    }
}
