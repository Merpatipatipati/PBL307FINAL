<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine if the user can view the product.
     */
    public function view(User $user, Product $product)
    {
        // Semua pengguna dapat melihat produk
        return true;
    }

    /**
     * Determine if the user can update the product.
     */
    public function update(User $user, Product $product)
    {
        // Hanya pengguna yang meng-upload produk yang bisa meng-update
        return $user->id === $product->user_id;
    }

    /**
     * Determine if the user can delete the product.
     */
    public function delete(User $user, Product $product)
    {
        // Hanya pengguna yang meng-upload produk yang bisa menghapus
        return $user->id === $product->user_id;
    }

    /**
     * Determine if the user can report the product.
     */
    public function report(User $user, Product $product)
    {
        // Semua pengguna dapat melaporkan produk
        return true;
    }
}
