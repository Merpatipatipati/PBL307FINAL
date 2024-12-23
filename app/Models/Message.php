<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;

    protected $keyType = 'string'; // Pastikan keyType diatur ke string
    public $incrementing = false; // Non-incrementing untuk UUID

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); // Generate UUID saat membuat model baru
        });
    }

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'is_read',
        'sent_at',
    ];

    public function sender()
{
    return $this->belongsTo(User::class, 'sender_id');
}

// In App\Models\Message.php
protected $casts = [
    'sent_at' => 'datetime',
];

}
