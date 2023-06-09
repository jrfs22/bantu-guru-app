<?php

namespace App\Models\api;

use Illuminate\Support\Str;
use App\Models\api\PengajarBimbelModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListBimbelModel extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'list_bimbel';
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
     * Get all of the pengajar for the ListBimbelModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengajar(): HasMany
    {
        return $this->hasMany(PengajarBimbelModel::class, 'list_bimbel_id', 'id');
    }

    /**
     * Get all of the materi for the ListBimbelModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materi(): HasMany
    {
        return $this->hasMany(MateriBimbelModel::class, 'list_bimbel_id', 'id');
    }
}
