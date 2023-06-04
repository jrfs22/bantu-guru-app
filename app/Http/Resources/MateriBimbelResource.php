<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MateriBimbelResource extends JsonResource
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
            'deskripsi' => $this->deskripsi,
            'list_bimbel_id' => $this->list_bimbel_id,
            'file' => $this->file,
            'user_id' => $this->user_id,
            'author' => $this->whenLoaded('author')
        ];
    }
}
