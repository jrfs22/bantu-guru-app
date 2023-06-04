<?php

namespace App\Models\api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MateriBimbelModel extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'materi_bimbel';
    protected $fillable = [
        'deskripsi', 'list_bimbel_id', 'user_id', 'file'
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
     * Get the author that owns the MateriBimbelModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
