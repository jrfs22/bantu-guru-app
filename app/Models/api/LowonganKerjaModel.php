<?php

namespace App\Models\api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LowonganKerjaModel extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'lowongan_kerja';
    protected $fillable = [
        'nama', 'image','view', 'status',
        'validasi_by', 'user_id'
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
     * Get the user that owns the LowonganKerjaModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function validasi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validasi_by', 'id');
    }

    /**
     * Get the user that owns the LowonganKerjaModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
