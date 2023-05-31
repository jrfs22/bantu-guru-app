<?php

namespace App\Models\api;

use Illuminate\Support\Str;
use App\Models\api\DonaturModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonasiModel extends Model
{
    use HasFactory;
    protected $table = "donasi";
    public $incrementing = false;

    protected $fillable = [
        "nama", "deskripsi",
        "tanggal", "gambar"
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
     * Get all of the donatur for the DonasiModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donatur(): HasMany
    {
        return $this->hasMany(DonaturModel::class, 'donasi_id', 'id');
    }
}
