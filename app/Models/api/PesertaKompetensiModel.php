<?php

namespace App\Models\api;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesertaKompetensiModel extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'list_kompetensi';
    protected $fillable = [
        'kompetensi_id', 'user_id', 'status'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            if($model->getKey() == null){
                $model->setAttribute($model->getKeyName(), Str::orderedUuid()->toString());
            }
        });
    }
}
