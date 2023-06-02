<?php

namespace App\Models\api;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlamatModel extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'alamat';
    protected $fillable = [
        'user_id', 'kecamatan_id',
        'kota_id', 'provinsi_id',
        'detail_alamat', 'kode_pos'
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
