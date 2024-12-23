<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\PostReport;
use App\Models\ProductReport;
use App\Models\Conversation;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Konstruktor untuk melindungi dashboard dengan middleware
    public function __construct()
    {
        // Pastikan hanya admin yang dapat mengakses controller ini
        $this->middleware('auth:admin')->except('showLoginForm', 'login'); // Login form dan login tidak membutuhkan autentikasi
        $this->middleware('role:admin')->only('dashboard'); // Hanya admin yang dapat mengakses dashboard
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Memproses login admin
    public function login(Request $request)
    {
        // Validasi input yang diterima
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        // Mendapatkan kredensial dari input
        $credentials = $request->only('username', 'password');
    
        // Mencoba login dengan guard admin
        if (Auth::guard('admin')->attempt($credentials)) {
            // Cek apakah user yang login memiliki role admin
            $user = Auth::guard('admin')->user();
            if ($user->role === 'admin') {
                // Jika user adalah admin, arahkan ke dashboard admin
                return redirect()->route('admin.dashboard');
            } else {
                // Jika user bukan admin, logout dan tampilkan pesan error
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page.');
            }
        }
    
        // Jika kredensial salah, tampilkan pesan error
        return redirect()->route('admin.login')->with('error', 'Invalid username or password.');
    }

    // Halaman dashboard admin
    public function dashboard()
{
    $totalUsers = [
        'verified' => User::where('status', 'verified')->count(),
        'non_verified' => User::where('status', 'non-verified')->count(),
        'banned' => User::where('status', 'banned')->count(),
    ];

    $totalProducts = [
        'Electronics and Gadgets' => Product::where('tag_barang', 'Electronics and Gadgets')->count(),
        'Fashion' => Product::where('tag_barang', 'Fashion')->count(),
        'Health and Beauty' => Product::where('tag_barang', 'Health and Beauty')->count(),
        'Food and Beverages' => Product::where('tag_barang', 'Food and Beverages')->count(),
        'Home Appliances' => Product::where('tag_barang', 'Home Appliances')->count(),
        'Furniture' => Product::where('tag_barang', 'Furniture')->count(),
        'Sports and Outdoor' => Product::where('tag_barang', 'Sports and Outdoor')->count(),
        'Baby and Kids' => Product::where('tag_barang', 'Baby and Kids')->count(),
        'Automotive' => Product::where('tag_barang', 'Automotive')->count(),
        'School Supplies' => Product::where('tag_barang', 'School Supplies')->count(),
        'Agriculture and Gardening' => Product::where('tag_barang', 'Agriculture and Gardening')->count(),
        'Construction Supplies' => Product::where('tag_barang', 'Construction Supplies')->count(),
        'More' => Product::where('tag_barang', 'More')->count(),
    ];

    $totalPosts = [
        'with_image' => Post::whereNotNull('image_url')->count(), // Posts with an image
        'without_image' => Post::whereNull('image_url')->count(), // Posts without an image
    ];

    return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalPosts'));
}


    // Logout admin
    
public function logout(Request $request)
{
    // Proses logout hanya jika sudah login
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    // Kembali ke halaman login tanpa pesan 403
    return redirect()->route('admin.login');
}

    // Menampilkan daftar pengguna
    public function users()
    {
        $users = User::all(); // Pastikan model User tersedia
        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'status' => 'required|string',
        'role' => 'required|string|in:user,admin',
        'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Cari user berdasarkan ID
    $user = User::findOrFail($id);

    // Update data user
    $user->update($validated);

    return redirect()->route('admin.users')->with('success', 'User updated successfully.');
}

    // Menampilkan daftar produk
    public function products()
    {
        // Ambil data produk beserta relasi pengguna
        $products = Product::with('user')->get();

        // Kirim data ke view
        return view('admin.products', compact('products'));
    }

    public function takedown($id)
{
    $product = Product::findOrFail($id);

    // Pastikan hanya admin yang dapat melakukan takedown
    if (auth()->user()->role != 'admin') {
        return redirect()->route('admin.products')->with('error', 'You do not have permission to perform this action.');
    }

    // Set status takedown ke true
    $product->update(['takedown' => true]);

    return redirect()->route('admin.products')->with('success', 'Product has been taken down.');
}

public function untakedown($id)
{
    $product = Product::findOrFail($id);

    // Pastikan hanya admin yang dapat melakukan untakedown
    if (auth()->user()->role != 'admin') {
        return redirect()->route('admin.products')->with('error', 'You do not have permission to perform this action.');
    }

    // Set status takedown ke false
    $product->update(['takedown' => false]);

    return redirect()->route('admin.products')->with('success', 'Product has been restored.');
}


    // Menampilkan daftar percakapan
    public function conversations()
    {

        // Ambil semua percakapan dengan relasi user1 dan user2
        // Ambil semua post dengan relasi user
    $posts = Post::with('user')->get();

    return view('admin.conversations', compact('posts'));
    }

    // Menampilkan profil admin
    public function profile()
{
    // Use Auth guard for 'admin' to get the authenticated admin user
    $admin = Auth::guard('admin')->user();

    // Check if admin is authenticated, otherwise redirect or show an error
    if (!$admin) {
        return redirect()->route('admin.login')->with('error', 'Please login as admin');
    }

    // Pass the admin data to the view
    return view('admin.profile', compact('admin'));
}
    public function reports()
{
    // Ambil laporan produk dengan relasi terkait
    $productReports = ProductReport::with(['product', 'reporter', 'product.user'])->get();

    // Ambil laporan postingan dengan relasi terkait
    $postReports = PostReport::with(['post', 'reporter', 'post.user'])->get();

    // Kirim data ke view
    return view('admin.reports', compact('productReports', 'postReports'));
}

public function showDetail($id, $type)
{
    if ($type === 'product') {
        $report = ProductReport::with(['product', 'reporter', 'product.user'])->findOrFail($id);
        return response()->json([
            'reporter' => $report->reporter->username ?? 'N/A',
            'product_name' => $report->product->nama_barang ?? 'N/A',
            'seller' => $report->product->user->username ?? 'N/A',
            'reason' => $report->reason ?? 'N/A',
            'admin_response' => $report->admin_response ?? 'Pending',
        ]);
    } else {
        $report = PostReport::with(['post', 'reporter', 'post.user'])->findOrFail($id);
        return response()->json([
            'reporter' => $report->reporter->username ?? 'N/A',
            'post_content' => $report->post->content ?? 'N/A',
            'author' => $report->post->user->username ?? 'N/A',
            'reason' => $report->reason ?? 'N/A',
            'admin_response' => $report->admin_response ?? 'Pending',
        ]);
    }
}

public function takedownPost($id)
    {
        $post = Post::findOrFail($id);
        
        // Change status to 'takedown'
        $post->status = 'takedown';
        $post->save();
        
        return redirect()->route('admin.posts')->with('success', 'Post has been takedown.');
    }

    // Untakedown the post
    public function untakedownPost($id)
    {
        $post = Post::findOrFail($id);
        
        // Change status to 'active'
        $post->status = 'active';
        $post->save();
        
        return redirect()->route('admin.posts')->with('success', 'Post has been untakedown.');
    }

    public function submitResponse($reportId, $reportType, Request $request)

    {
        // Ambil respons dari form
        $response = $request->input('response');

        // Proses berdasarkan tipe laporan (produk atau post)
        if ($reportType == 'product') {
            $report = ProductReport::findOrFail($reportId);
            $report->admin_response = $response;
            $report->status = 'Submitted'; // Perbarui status menjadi 'Submitted'
            $report->save();
        } elseif ($reportType == 'post') {
            $report = PostReport::findOrFail($reportId);
            $report->admin_response = $response;
            $report->status = 'Submitted'; // Perbarui status menjadi 'Submitted'
            $report->save();
        }

        // Redirect kembali ke halaman laporan dengan pesan sukses
        return redirect()->route('admin.reports')->with('success', 'Response submitted successfully');
    }
}
