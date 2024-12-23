<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan oleh model ini (opsional, jika nama tabel tidak mengikuti konvensi)
    protected $table = 'otps';

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = ['user_id', 'otp', 'expires_at'];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
