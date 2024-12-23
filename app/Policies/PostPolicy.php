<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Menentukan apakah pengguna dapat memperbarui postingan
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id; // Hanya pemilik yang bisa mengupdate
    }

    /**
     * Menentukan apakah pengguna dapat menghapus postingan
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id; // Hanya pemilik yang bisa menghapus
    }

    /**
     * Menentukan apakah pengguna dapat melaporkan postingan
     */
    public function report(User $user, Post $post)
    {
        // Semua pengguna bisa melaporkan
        return true;
    }
}
