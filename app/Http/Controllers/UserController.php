<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Tampilkan halaman dashboard pengguna.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil semua postingan milik user yang sedang login
        $posts = Post::where('user_id', $user->id)->get();
        
        // Ambil semua barang milik user yang sedang login, termasuk atribut lengkapnya
        $products = Product::where('user_id', $user->id)->get(['id', 'nama_barang', 'harga_barang', 'tag_barang', 'jumlah_barang', 'deskripsi_barang','gambar_barang']);

        return view('user.dashboard', compact('user', 'posts', 'products'));
    }

public function showAllProducts()
{
    $user = Auth::user();
    // Assuming you have a 'status' column where 'takedown' represents inactive products
    $products = Product::where('user_id', $user->id)
                        ->where('takedown', '!=', '1') // Exclude takedown products
                        ->get();

    return view('user.products', compact('products'));
}

public function managePosts()
{
    // Ambil semua post yang dimiliki oleh user yang tidak dibanned dan tidak takedown, serta relasi user dan komentar
    $posts = Post::with('user', 'comments') // Eager load user and comments for all posts
                ->whereHas('user', function ($query) {
                    $query->active(); // Hanya user yang tidak dibanned
                })
                ->where('status', '!=', 'takedown') // Pastikan post tidak dalam status takedown
                ->latest() // Urutkan berdasarkan yang terbaru
                ->get();

    $canUpdate = [];
    $canDelete = [];
    $canReport = [];

    // Cek kebijakan untuk update, delete, dan report per post
    foreach ($posts as $post) {
        $canUpdate[$post->id] = auth()->user()->can('update', $post);
        $canDelete[$post->id] = auth()->user()->can('delete', $post);
        $canReport[$post->id] = auth()->user()->can('report', $post);
    }

    // Mengirimkan data ke view
    return view('user.managePosts', compact('posts', 'canUpdate', 'canDelete', 'canReport'));
}
    /**
     * Update foto profil pengguna.
     */
    public function updatePhoto(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('photoProfile', 'public');

        $user = Auth::user();
        
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->photo = 'photoProfile/' . basename($photoPath);
        $user->save();

        // Redirect back to the dashboard view with success message
        return redirect()->route('user.dashboard')->with('success', 'Profile photo updated successfully.');
    }

    // If no photo uploaded, just redirect back to dashboard
    return redirect()->route('user.dashboard')->with('error', 'No photo uploaded.');
}

    /**
     * Buat postingan baru.
     */
    public function createPost(Request $request)
{
    if ($request->isMethod('post')) {
        // Validasi input
        $request->validate([
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Membuat post baru
        $post = new Post();
        $post->id = Str::uuid(); // Generate UUID untuk post
        $post->user_id = Auth::id(); // Menyimpan ID pengguna yang sedang login
        $post->content = $request->content; // Menyimpan konten post

        // Jika ada gambar yang diupload, simpan gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gambar_post', 'public');
            $post->image_url = $imagePath; // Menyimpan path gambar
        }

        // Simpan post ke database
        $post->save();

        // Redirect ke halaman managePosts dengan pesan sukses
        return redirect()->route('user.managePosts')->with('success', 'Post berhasil dibuat.');
    }

    // Jika method bukan POST, tampilkan form untuk membuat post
    return view('user.create');
}
    /**
     * Menampilkan form edit untuk post tertentu.
     */
    public function editPost($id)
{
    // Cari post berdasarkan ID dan pastikan user_id sesuai
    $post = Post::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    // Tampilkan form edit dengan data post
    return view('user.edit_post', compact('post'));
}

    
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
    
        // Hanya pemilik postingan yang bisa menghapus
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        $post->delete();
    
        return redirect()->route('user.managePosts')->with('success', 'Post berhasil dihapus.');
    }

    /**
     * Mengupdate postingan pengguna.
     */
    public function updatePost(Request $request, $id)
{
    // Retrieve the post by its ID
    $post = Post::findOrFail($id);

    // Validasi input
    $request->validate([
        'content' => 'required|string|max:500',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
    ]);

    // Update konten
    $post->content = $request->input('content');

    // Ensure the user_id is set to the authenticated user's ID (to prevent unauthorized access)
    $post->user_id = auth()->id(); 

    // Update gambar jika ada
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($post->image_url) {
            Storage::delete('public/' . $post->image_url);
        }

        // Simpan gambar baru
        $post->image_url = $request->file('image')->store('gambar_post', 'public');
    }

    // Simpan perubahan (this will update the existing record, not create a new one)
    $post->save();

    return redirect()->route('user.managePosts', $post->user_id)->with('success', 'Postingan berhasil diperbarui!');
}
    /**
     * Menghapus postingan pengguna.
     */
    public function deletePost($id)
{
    // Cari post dan pastikan user_id sesuai
    $post = Post::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    // Hapus postingan
    $post->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('user.managePosts')->with('success', 'Post berhasil dihapus.');
}

public function show($id)
{
    // Retrieve the user by ID
    $user = User::findOrFail($id);

    // Retrieve the user's products that are not takedown
    $products = Product::where('user_id', $id)
                        ->where('takedown', '!=', '1') // Filter produk yang statusnya bukan takedown
                        ->get();

    // Retrieve the user's posts that are not takedown
    $posts = Post::where('user_id', $id)
                    ->where('status', '!=', 'takedown') // Filter post yang statusnya bukan takedown
                    ->get();

    // Return the view with data
    return view('user.show', [
        'user' => $user,
        'products' => $products,
        'posts' => $posts,
    ]);
}

public function showPost(Post $post)
{
    // Pastikan post yang ditampilkan tidak dalam status banned
    if ($post->status === 'takedown') {
        // Redirect atau tampilkan pesan error jika post dibanned
        return redirect()->route('home')->with('error', 'This post has been banned.');
    }

    // Menampilkan post di view
    return view('user.showPost', compact('post'));
}
public function allPost()
{
    // Retrieve the authenticated user
    $user = auth()->user();

    // Retrieve all posts of the authenticated user, excluding takedown posts
    $posts = Post::where('user_id', $user->id)
                 ->where('status', '!=', 'takedown') // Filter posts that are not takedown
                 ->get();

    // Return the view with data
    return view('user.allPost', [
        'user' => $user,
        'posts' => $posts,
    ]);
}


public function showProducts($id)
{
    $user = User::findOrFail($id); // Temukan user berdasarkan ID
    $products = Product::where('user_id', $id)
                       ->where('takedown', '!=', '1') // Filter produk yang tidak di-takedown
                       ->get(); // Ambil produk yang dimiliki user
    return view('user.productsOther', compact('user', 'products')); // Kirim data ke view
}

public function showPosts($id)
{
    $user = User::findOrFail($id); // Temukan user berdasarkan ID
    $posts = Post::where('user_id', $id)
                 ->where('status', '!=', 'takedown') // Filter posts yang tidak di-takedown
                 ->get(); // Ambil post yang dimiliki user
    return view('user.postsOther', compact('user', 'posts')); // Kirim data ke view
}
}
