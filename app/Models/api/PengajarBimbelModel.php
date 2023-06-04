<?php

namespace App\Models\api;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\api\MateriBimbelModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajarBimbelModel extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $table = 'pengajar_bimbel';
    protected $fillable = [
        'user_id', 'list_bimbel_id'
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
     * Get all of the materi for the PengajarBimbelModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materi(): HasMany
    {
        return $this->hasMany(MateriBimbelModel::class, 'list_bimbel_id', 'list_bimbel_id');
    }

    /**
     * Get the user that owns the PesertaBimbelModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id', 'nama_lengkap', 'no_hp', 'npa_pgri');
    }
}
