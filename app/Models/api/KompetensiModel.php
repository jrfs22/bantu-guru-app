<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Model;
use App\Models\api\PesertaKompetensiModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KompetensiModel extends Model
{
    use HasFactory;
    protected $table = 'kompetensi';
    protected $fillable = [
        'nama', 'tanggal_mulai', 'tanggal_selesai',
        'jam_mulai', 'jam_selesai', 'tipe', 'max_peserta',
        'deskripsi', 'poster', 'status'
    ];

    /**
     * Get all of the peserta for the KompetensiModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peserta(): HasMany
    {
        return $this->hasMany(PesertaKompetensiModel::class, 'kompetensi_id', 'id');
    }
}
