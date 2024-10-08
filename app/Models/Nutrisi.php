<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrisi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'users_id',
        'nama',
        'tanggal',
        'jumlah_kalori',
        'type',
    ];

    public function kalori()
    {
        return $this->belongsTo(Kalori::class, 'kaloris_id');
    }
}
