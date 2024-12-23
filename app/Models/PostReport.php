<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostReport extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'reason'];

    // Relationship to the user who reported the post
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id'); // Assuming 'user_id' is the reporter
    }

    // Relationship to the post being reported
    public function post()
{
    return $this->belongsTo(Post::class); // Menghubungkan laporan ke post yang dilaporkan
}

// Relasi ke User yang mengupload Post
public function uploader()
{
    return $this->post->user; // Mengambil user yang memiliki post (bukan user yang melaporkan)
}
}
