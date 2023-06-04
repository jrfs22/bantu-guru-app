<?php

namespace App\Models\api;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Models\api\PembimbingKaryaTulisModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuKaryaTulisModel extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'menu_pembimbing_karya_tulis';
    protected $fillable = [
        'nama', 'gambar'
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


/**
 * Get all of the pembimbing for the MenuKaryaTulisModel
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
    public function pembimbing(): HasMany
    {
        return $this->hasMany(PembimbingKaryaTulisModel::class, 'pembimbing_menu_id', 'id');
    }
}
