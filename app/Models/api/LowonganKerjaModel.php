<?php

namespace App\Models\api;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LowonganKerjaModel extends Model
{
    use HasFactory;
    protected $table = 'lowongan_kerja';
    protected $fillable = [
        "nama", "file","user_id","view", "status",
        "validasi_by"
    ];

    /**
     * Get the user that owns the LowonganKerjaModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id ', 'id');
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
}
