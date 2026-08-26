<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Transaksie extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'transaksies';

    protected $fillable = [
        'id_car',
        'tanggal',
        'telepon',
        'durasi_sewa',
        'total',
        'status',
        'atas_nama',
        'bukti_img',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'id_car');
    }
}
