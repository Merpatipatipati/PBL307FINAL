<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'user_id',
        'content',
        'image_url',
        'title',
    ];

    // Pastikan ID adalah string (UUID)
    protected $keyType = 'string';
    public $incrementing = false;

    // Pastikan ID diperlakukan sebagai string
    protected $casts = [
        'id' => 'string',
    ];

    /**
     * Relasi dengan model User
     * Setiap post dimiliki oleh satu pengguna.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->active(); // Gunakan scopeActive
    }

    public function comments()
{
    return $this->morphMany(Comment::class, 'commentable');
}
    /**
     * Boot method untuk menggunakan UUID.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); // Generate UUID sebelum menyimpan
        });
    }

public function reports()
{
    return $this->hasMany(PostReport::class);
}
}
