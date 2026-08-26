<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Car extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'cars';

    protected $fillable = [
        'id_kelas',
        'id_brand',
        'nama',
        'warna',
        'tahun',
        'transmisi',
        'kursi',
        'harga',
        'status',
        'img',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function transaksies(): HasMany
    {
        return $this->hasMany(Transaksie::class, 'id_car');
    }
}
