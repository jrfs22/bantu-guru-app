<?php

namespace App\Models\api;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonaturModel extends Model
{
    use HasFactory;
    protected $table = 'donatur';
    protected $fillable = [
        'user_id', 'donasi_id', 'catatan', 
        'nominal', 'bukti_pembayaran'
    ];

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
}
