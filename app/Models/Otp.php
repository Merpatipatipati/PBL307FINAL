<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Otp extends Model
{
    use HasFactory;

    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    // Tentukan tabel yang digunakan oleh model ini
    protected $table = 'otps';

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = ['id', 'user_id', 'otp', 'expires_at'];

    // Event untuk meng-generate UUID sebelum record dibuat
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Generate UUID
            }
        });
    }

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

