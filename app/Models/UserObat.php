<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserObat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'users_id',
        'obats_id',
        'jam',
        'tanggal',
        'status',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obats_id');
    }
}
