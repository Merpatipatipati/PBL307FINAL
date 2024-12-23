<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Post;
use App\Models\ProductReport;
use App\Models\PostReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Menampilkan laporan produk milik user
    public function showReportForm($id)
{
    // Pastikan user sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You need to be logged in to report a product.');
    }

    // Ambil detail produk berdasarkan ID
    $product = Product::findOrFail($id);

    // Pastikan user tidak dapat melaporkan produk miliknya sendiri
    if (auth()->id() === $product->user_id) {
        return redirect()->route('home')->with('error', 'You cannot report your own product.');
    }

    // Kirim data produk ke view
    return view('products.report', compact('product'));
}


public function submitReport(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'reason' => 'required|string|max:1000',
    ]);

    // Simpan laporan
    ProductReport::create([
        'user_id' => auth()->id(),
        'product_id' => $validated['product_id'],
        'reason' => $validated['reason'],
    ]);

    return redirect()->route('reports.product.form', $validated['product_id'])
        ->with('success', 'Your report has been submitted successfully.');
}


    public function showPostReportForm($id)
    {
        $post = Post::findOrFail($id);
    
        // Cek apakah user mencoba melaporkan postingan miliknya sendiri
        if (auth()->id() === $post->user_id) {
            return redirect()->back()->with('error', 'You cannot report your own post.');
        }
    
        // Menampilkan view dari direktori view/user/reportPosts.blade.php
        return view('user.reportPosts', compact('post'));
    }

    /**
     * Handle the submission of the report form.
     */
    public function reportPost(Request $request, $id)
{
    $post = Post::findOrFail($id);

    // Simpan alasan laporan ke database atau proses sesuai kebutuhan
    $report = new PostReport();
    $report->post_id = $post->id;
    $report->user_id = auth()->id();
    $report->reason = $request->input('reason');
    $report->save();

    // Setelah laporan berhasil, kembali ke halaman posts.index
    return redirect()->route('user.managePosts')->with('success', 'Post telah dilaporkan');
}
}
