<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengajarBimbelResource extends JsonResource
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
            'user_id' => $this->user_id,
            'list_bimbel_id' => $this->list_bimbel_id,
            'jumlah_materi' => $this->whenLoaded('materi', function () {
                return count($this->materi);
            }),
            'user' => $this->whenLoaded('user')
        ];
    }
}
