<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{

    public function storeComment(Request $request, $productId)
{
    $validated = $request->validate([
        'content' => 'required|string|max:255',
    ]);

    // Menyimpan komentar
    $comment = Comment::create([
        'content' => $validated['content'],
        'user_id' => auth()->id(),
        'commentable_id' => $productId,
        'commentable_type' => Product::class,
    ]);

    // Mengambil produk dengan ID yang sesuai
    $product = Product::findOrFail($productId);
    $canUpdate = auth()->user()->can('update', $product);
    $canDelete = auth()->user()->can('delete', $product);
    $canReport = auth()->user()->can('report', $product);

    // Mengambil komentar terkait produk beserta balasan dan informasi pengguna
    $comments = $product->comments()
        ->with('replies', 'user') // Jika ingin menampilkan balasan dan data pengguna
        ->orderBy('created_at', 'desc')
        ->get();

    // Mengembalikan tampilan produk dengan data komentar yang baru ditambahkan
    return view('products.show', compact('product', 'canUpdate', 'canDelete', 'canReport','comments'));
}

public function addComment(Request $request, $postId)
{
    $request->validate([
        'content' => 'required|max:255',
    ]);

    $post = Post::findOrFail($postId);

    // Check if the post's user is banned
    if ($post->user->is_banned) {
        // Optionally, you can redirect back or show a message
        return redirect()->back()->with('error', 'This post belongs to a banned user.');
    }

    // Only allow the comment if the user is not banned
    if (auth()->user()->is_banned) {
        return redirect()->back()->with('error', 'You are banned from commenting.');
    }

    // Create the comment
    $comment = $post->comments()->create([
        'user_id' => auth()->id(),
        'content' => $request->content,
    ]);

    // Reload posts with the user relationship, filtering out banned users
    $posts = Post::with('user')
        ->whereHas('user', function ($query) {
            $query->active();  // Only include non-banned users
        })
        ->latest()
        ->get();

    return view('user.managePosts', compact('posts'));
}
}
