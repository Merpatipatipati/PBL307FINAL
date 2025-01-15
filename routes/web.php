<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\inside\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MessageboxController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Routing untuk halaman Help
Route::get('/dashboard/help', function () {
    return view('dashboard.help');
})->name('help');

Route::get('/about', [DashboardController::class, 'about'])->name('about');
Route::get('/faq', [DashboardController::class, 'faq'])->name('faq');

// Routing untuk halaman Login
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Routing untuk halaman Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::post('/send-otp/{id}', [RegisterController::class, 'sendOtp'])->name('otp.send');
    // Tampilkan form validasi OTP
    Route::get('/validate-otp/{id}', [RegisterController::class, 'showOtpForm'])->name('otp.form');

    // Proses validasi kode OTP
    Route::post('/validate-otp/{id}', [RegisterController::class, 'validateOtp'])->name('otp.validate');

    Route::get('forgot-password', [RegisterController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [RegisterController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [RegisterController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [RegisterController::class, 'resetPassword'])->name('password.update');
});

// Middleware untuk autentikasi
Route::middleware(['auth', 'check.status','check.takedown'])->group(function () {
    // Dashboard Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route untuk logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::post('/dashboard/update-photo', [UserController::class, 'updatePhoto'])->name('user.updatePhoto');

    Route::get('/user/create-post', [UserController::class, 'createPost'])->name('user.createPosts');
    Route::get('/user/manage-posts', [UserController::class, 'managePosts'])->name('user.managePosts');
    // Menyimpan post yang dibuat
    Route::post('/user/create-post', [UserController::class, 'createPost'])->name('user.createPost');
    // Route to handle the form submission (POST method)
    Route::post('/dashboard/create-post', [UserController::class, 'storePost'])->name('user.storePost');
    Route::get('/dashboard/edit-post/{id}', [UserController::class, 'editPost'])->name('user.editPost');
    Route::put('/dashboard/update-post/{id}', [UserController::class, 'updatePost'])->name('user.updatePost');
    Route::delete('/dashboard/delete-post/{id}', [UserController::class, 'deletePost'])->name('user.deletePost');
    Route::get('/reports/post/{id}', [ReportController::class, 'showReportFormPost'])->name('reports.post.form');
    Route::post('/posts/{postId}/comments', [CommentController::class, 'addComment'])->name('comments.post');
    // GET: Menampilkan form laporan untuk postingan
    Route::get('/posts/{id}/report', [ReportController::class, 'showPostReportForm'])->name('reports.post.show');
    Route::get('/user/{id}/all-posts', [UserController::class, 'allPost'])->name('user.allPost');

    // POST: Mengirim laporan untuk postingan
    Route::post('/report/post/{id}', [ReportController::class, 'reportPost'])->name('reports.post.submit');


    Route::get('/chat/{id}', [MessageboxController::class, 'start'])->name('chat.user');

    Route::get('/user/products', [UserController::class, 'showAllProducts'])->name('user.products');

    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/post/{post}', [UserController::class, 'showPost'])->name('post.show');
   Route::get('/products', [ProductController::class, 'index'])->name('products.index'); 
    // Route untuk produk
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); // Formulir upload produk
    Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // Menyimpan produk baru
    Route::get('/product/image/{id}', [ProductController::class, 'getImage'])->name('product.image');
Route::get('/reports/products/{id}', [ReportController::class, 'showReportForm'])->name('reports.product.form');
    Route::post('/reports/products', [ReportController::class, 'submitReport'])->name('reports.product.submit');
    Route::get('/user/{id}/products', [UserController::class, 'showProducts'])->name('user.productsOther');
    Route::get('/user/{id}/posts', [UserController::class, 'showPosts'])->name('user.allPostOther');

    Route::match(['get', 'post'], '/products/{id}/show', [ProductController::class, 'show'])->name('product.show');

    
    // Route for displaying the product edit form and updating the product (PUT method)
     // Route to show the form for editing a product
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

     // Route to handle updating a product
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    // Route to delete a product
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    // Route untuk menyimpan komentar
    Route::post('/product/{id}/comment', [CommentController::class, 'storeComment'])->name('product.storeComment');
    
    
    Route::get('/category/{category}', [ProductController::class, 'showCategory'])->name('category');


    // Rute untuk pesan
Route::middleware('web')->group(function () {
    Route::prefix('messages')->group(function () {
        Route::get('/', [MessageboxController::class, 'index'])->name('message.index'); // Daftar pesan
        Route::get('/start/{userId}', [MessageboxController::class, 'start'])->name('message.start'); // Memulai chat
        Route::get('/{conversation}', [MessageboxController::class, 'show'])->name('message.show'); // Menampilkan pesan
    });
});

});

Route::prefix('admin')->group(function () {
    // Rute login menggunakan middleware admin.guest
    Route::middleware(['admin.guest','check.vpn.ip'])->group(function () {
        Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login.form');
        Route::post('login', [AdminController::class, 'login'])->name('admin.login');
    });

    // Rute yang dilindungi oleh middleware auth.admin
    Route::middleware(['auth:admin', 'role:admin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('users', [AdminController::class, 'users'])->name('admin.users');
        Route::put('users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');


        
    // Products Management
    Route::get('products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('products/{id}/takedown', [AdminController::class, 'takedown'])->name('admin.products.takedown');
    Route::post('products/{id}/untakedown', [AdminController::class, 'untakedown'])->name('admin.products.untakedown');

    
    // Conversations Management
    Route::get('conversations', [AdminController::class, 'conversations'])->name('admin.posts');
    Route::post('admin/posts/{id}/takedown', [AdminController::class, 'takedownPost'])->name('admin.post.takedown');
Route::post('admin/posts/{id}/untakedown', [AdminController::class, 'untakedownPost'])->name('admin.post.untakedown');
    // Reports Management
    Route::get('reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('reports/{id}/{type}', [AdminController::class, 'showDetail'])->name('admin.reports.detail');
    Route::post('{reportId}/{reportType}/submit', [AdminController::class, 'submitResponse'])->name('reports.submit');
    // Profile Management
    Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');
});


    
});


