<?php

namespace App\Models\api;

use App\Models\api\DonaturModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonasiModel extends Model
{
    use HasFactory;
    protected $table = "donasi";

    protected $fillable = [
        "nama", "deskripsi",
        "tanggal", "gambar",
        "status"
    ];

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
