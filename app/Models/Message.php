<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;

    // Mengatur type ID menjadi string karena kita menggunakan UUID
    protected $keyType = 'string';

    // Non-incrementing untuk UUID
    public $incrementing = false;

    // Menambahkan UUID ketika model baru dibuat
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Mengenerate UUID secara otomatis untuk ID
            $model->id = (string) Str::uuid();
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

    // Relasi dengan pengirim pesan (user)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relasi dengan percakapan (conversation)
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    // Casting atribut 'sent_at' menjadi tipe datetime
    protected $casts = [
        'sent_at' => 'datetime',
    ];
}

