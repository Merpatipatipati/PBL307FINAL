<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string'; // Mengatur keyType ke string untuk UUID
    public $incrementing = false; // Non-incrementing untuk UUID

    /**
     * Boot method untuk generate UUID saat creating.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate UUID untuk id jika belum ada
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Properti yang dapat diisi secara mass-assignment.
     */
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'role',
        'status',
        'photo', // Tambahkan ini jika menggunakan photo profile
    ];

    /**
     * Properti yang harus disembunyikan dalam array atau JSON.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relasi ke percakapan (user sebagai user_id_1).
     */
    public function conversations1()
    {
        return $this->hasMany(Conversation::class, 'user_id_1');
    }

    /**
     * Relasi ke percakapan (user sebagai user_id_2).
     */
    public function conversations2()
    {
        return $this->hasMany(Conversation::class, 'user_id_2');
    }

    /**
     * Helper method untuk memeriksa apakah user adalah admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Helper method untuk memeriksa apakah user adalah user biasa.
     */
    public function isUser()
    {
        return $this->role === 'user';
    }

    public function scopeActive($query)
{
    return $query->where('status', '!=', 'banned');
}
public function otps()
    {
        return $this->hasMany(Otp::class, 'user_id');
    }
}
