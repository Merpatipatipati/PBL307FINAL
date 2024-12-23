<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id', 'commentable_id', 'commentable_type'];

    // Polymorphic relationship
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
                    ->active(); // Filter user yang tidak banned
    }

    /**
     * Relasi polymorphic ke produk atau postingan.
     */
    public function reference()
    {
        return $this->morphTo();
    }

    


}
