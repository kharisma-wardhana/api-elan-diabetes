<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Artikel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'image',
        'content',
        'audio',
    ];

    public function getImageAttribute($value)
    {
        if (!$value) {
            throw new \Exception("File path is empty or invalid.");
        }
        return url(Storage::url($value));
    }
}
