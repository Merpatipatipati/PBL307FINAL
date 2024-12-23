<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan formulir untuk meng-upload barang
    public function create()
    {
        return view('products.create');
    }

    // Menampilkan produk berdasarkan kategori
    public function showCategory($category)
{
    // Ambil produk berdasarkan kategori dan filter user yang tidak banned
    if ($category == 'All') {
        // Ambil semua produk dari user yang tidak banned
        $products = Product::whereHas('user', function ($query) {
            $query->where('status', '!=', 'banned'); // Filter user yang tidak banned
        })->get();
    } else {
        // Ambil produk berdasarkan kategori (tag_barang) dari user yang tidak banned
        $products = Product::whereHas('user', function ($query) {
            $query->where('status', '!=', 'banned'); // Filter user yang tidak banned
        })->where('tag_barang', $category)->get();
    }

    // Kembalikan ke view dengan data produk dan kategori
    return view('products.category', compact('products', 'category'));
}



    // Menampilkan semua produk
    public function index()
{
    // Mengambil produk yang aktif beserta data user terkait
    $products = Product::active()->with('user')->get();
    
    // Mengirimkan data produk ke view
    return view('products.index', compact('products'));
}
    // Menampilkan gambar produk
    public function getImage($id)
    {
        $product = Product::findOrFail($id);
        $imageData = $product->gambar_barang;

        return response($imageData)->header('Content-Type', 'image/jpeg');
    }

    // Menampilkan detail produk
    public function show($id)
{
    $product = Product::with('user')->findOrFail($id);

    // Check if the user who owns the product is banned
    if ($product->user->banned) {
        abort(404, 'Product not found'); // Tampilkan halaman 404 jika user dibanned
    }

    // Check policies
    $canUpdate = auth()->check() && auth()->user()->can('update', $product);
    $canDelete = auth()->check() && auth()->user()->can('delete', $product);
    $canReport = auth()->check() && auth()->user()->can('report', $product);
    $comments = $product->comments()->get();

    return view('products.show', compact('product', 'canUpdate', 'canDelete', 'canReport', 'comments'));
}

    // Menyimpan produk yang di-upload
    public function store(Request $request)
{
    // Validasi data
    $request->validate([
        'nama_barang' => 'required|string|max:255',
        'tag_barang' => 'required|string|max:255',
        'harga_barang' => 'required|numeric',
        'jumlah_barang' => 'required|integer|min:1|',
        'deskripsi_barang' => 'nullable|string',
        'gambar_barang' => 'required|image|mimes:jpeg,png,jpg|max:10000',
    ]);

    // Mengambil data dari form
    $jumlah_barang = $request->input('jumlah_barang');

    // Jika jumlah barang lebih dari 99, ubah menjadi 99+
    if ($jumlah_barang > 99) {
        $jumlah_barang = '99+';  // Tampilkan 99+ jika lebih dari 99
    }

    $path = null;
    if ($request->hasFile('gambar_barang')) {
        $path = $request->file('gambar_barang')->store('public/gambar_produk');
    }

    // Simpan data produk ke database
    $product = new Product();
    $product->nama_barang = $request->nama_barang;
    $product->tag_barang = $request->tag_barang;
    $product->harga_barang = $request->harga_barang;
    $product->jumlah_barang = $request->jumlah_barang;
    $product->deskripsi_barang = $request->deskripsi_barang;
    $product->gambar_barang = $path; // Path gambar disimpan di kolom gambar_barang
    $product->user_id = auth()->id(); // Menyimpan ID pengguna yang mengunggah produk

    // Simpan ke database
    if ($product->save()) {
        return redirect()->route('home')->with('success', 'Produk berhasil ditambahkan');
    } else {
        return redirect()->back()->with('error', 'Gagal menyimpan produk');
    }
}

public function search(Request $request)
{
    $query = $request->input('query');

    // Pencarian Produk berdasarkan kolom nama_barang, deskripsi, dan tag_barang
    // Hanya produk yang dimiliki oleh user yang tidak banned dan produk yang tidak takedown
    $products = Product::where('nama_barang', 'like', '%' . $query . '%')
                        ->orWhere('deskripsi_barang', 'like', '%' . $query . '%')
                        ->orWhere('tag_barang', 'like', '%' . $query . '%')
                        ->whereHas('user', function ($query) {
                            $query->where('status', '!=', 'banned'); // Hanya produk milik user yang aktif
                        })
                        ->where('takedown', '!=', '1') // Pastikan produk tidak dalam status takedown
                        ->get();

    // Pencarian User berdasarkan kolom nama, email, atau username
    // Hanya user yang tidak banned
    $users = User::where('fullname', 'like', '%' . $query . '%')
                 ->orWhere('email', 'like', '%' . $query . '%')
                 ->orWhere('username', 'like', '%' . $query . '%')
                 ->active() // Hanya menampilkan user yang tidak dibanned
                 ->get();

    // Pencarian Post berdasarkan kolom judul, isi, atau tag
    // Hanya post yang dibuat oleh user yang tidak banned dan post yang tidak takedown
    $posts = Post::where('content', 'like', '%' . $query . '%')
                 ->whereHas('user', function ($query) {
                     $query->where('status', '!=', 'banned'); // Hanya post dari user yang tidak dibanned
                 })
                 ->where('status', '!=', 'takedown') // Pastikan post tidak dalam status takedown
                 ->get();

    // Kembalikan ke tampilan dengan semua data yang ditemukan
    return view('products.search', compact('products', 'users', 'posts'));
}

public function edit($id)
{
    // Retrieve the product by ID
    $product = Product::findOrFail($id);

    // Return the edit form with the product data
    return view('products.update', compact('product'));
}

public function update(Request $request, $id)
{
    // Retrieve the product by ID
    $product = Product::findOrFail($id);

    // Validate input data
    $request->validate([
        'nama_barang' => 'required|string|max:255',
        'deskripsi_barang' => 'nullable|string|max:1000',
        'harga_barang' => 'required|numeric',
        'jumlah_barang' => 'required|integer',
        'tag_barang' => 'nullable|string|max:255',
        'gambar_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Update product details
    $product->nama_barang = $request->input('nama_barang');
    $product->deskripsi_barang = $request->input('deskripsi_barang');
    $product->harga_barang = $request->input('harga_barang');
    $product->jumlah_barang = $request->input('jumlah_barang');
    $product->tag_barang = $request->input('tag_barang');

    // Update the image if a new one is provided
    if ($request->hasFile('gambar_barang')) {
        // Delete the old image if it exists
        if ($product->gambar_barang) {
            Storage::delete('public/' . $product->gambar_barang);
        }

        // Store the new image
        $product->gambar_barang = $request->file('gambar_barang')->store('product_images', 'public');
    }

    // Save the updated product
    $product->save();

    // Redirect to the updated product's details page with a success message
    return redirect()->route('product.show', $product->id)->with('success', 'Product updated successfully!');
}
public function destroy($id)
{
    // Temukan produk berdasarkan ID
    $product = Product::findOrFail($id);
    
    // Hapus gambar dari storage jika ada
    if ($product->gambar_barang) {
        Storage::delete($product->gambar_barang);
    }
    
    // Hapus produk dari database
    $product->delete();

    return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
}

   
}


