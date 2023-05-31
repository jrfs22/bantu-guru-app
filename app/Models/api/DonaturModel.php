<?php

namespace App\Models\api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonaturModel extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $table = 'donatur';
    protected $fillable = [
        'user_id', 'donasi_id', 'catatan', 
        'nominal', 'bukti_pembayaran', 'valid', 'status'
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
     * Get the user that owns the DonaturModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select(
            'id', 'nama_lengkap', 'gelar_depan', 'gelar_belakang'
        );
    }

    /**
     * Get all of the donasi for the DonaturModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function donasi(): belongsTo
    {
        return $this->belongsTo(DonasiModel::class, 'donasi_id', 'id')->select('id', 'nama');
    }
}
