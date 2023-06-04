<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListBimbelResource extends JsonResource
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
            'jumlah_materi' => $this->whenLoaded('materi', function (){
                return count($this->materi);
            }),
            'jumlah_pengajar' => $this->whenLoaded('pengajar', function (){
                return count($this->pengajar);
            }),
            'detail_pengajar' => $this->whenLoaded('pengajar', function(){
                return collect($this->pengajar)->each(function ($pengajar) {
                    $pengajar->user;
                    return $pengajar;
                });
            })
        ];
    }
}
