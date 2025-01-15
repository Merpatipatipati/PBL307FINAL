<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    // Nonaktifkan auto-increment dan gunakan string sebagai tipe ID
    public $incrementing = false;
    protected $keyType = 'string';

    // Generate UUID saat membuat model baru
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('takedown', false);
    }

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'nama_barang',
        'tag_barang',
        'harga_barang',
        'jumlah_barang',
        'deskripsi_barang',
        'gambar_barang', // Menyimpan path gambar, bukan data biner
        'user_id',
        'takedown',
    ];

    // Jika menggunakan timestamps (created_at dan updated_at)
    public $timestamps = true;

    // Relasi ke User
public function user()
{
    return $this->belongsTo(User::class); // Hilangkan scopeActive
}
    // Mendapatkan URL gambar dari path yang disimpan
    public function getImageUrlAttribute()
    {
        if ($this->gambar_barang) {
            // Gunakan Storage facade untuk mendapatkan URL dari storage, jika file disimpan di sistem storage Laravel
            return asset('storage/' . $this->gambar_barang);
        }
        return null; // Atau return gambar default
    }

    public function comments()
{
    return $this->morphMany(Comment::class, 'commentable');
}
}
