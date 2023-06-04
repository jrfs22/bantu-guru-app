<?php

namespace App\Models\api;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembimbingKaryaTulisModel extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'pembimbing_karya_tulis_online';
    protected $fillable = [
        'user_id', 'pembimbing_menu_id'
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
