<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaKompetensiModel extends Model
{
    use HasFactory;
    protected $table = 'list_kompetensi';
    protected $fillable = [
        'kompetensi_id', 'user_id', 'status'
    ];
}
