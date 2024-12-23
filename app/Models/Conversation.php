<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Conversation extends Model
{
    use HasFactory;

    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string'; 
    public $incrementing = false; 

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'user_id_1', 
        'user_id_2'
    ];

    // Auto-generate UUID saat pembuatan model
    protected static function boot()
    {
        parent::boot();

        // Set UUID untuk id saat model sedang dibuat
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relasi dengan User Model - user_id_1
    public function user1()
    {
        return $this->belongsTo(User::class, 'user_id_1');
    }

    // Relasi dengan User Model - user_id_2
    public function user2()
    {
        return $this->belongsTo(User::class, 'user_id_2');
    }

    // Relasi dengan Message Model
    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }
}

