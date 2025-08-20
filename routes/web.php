<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
// use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\SupportController;

Route::get('/contact-support', [SupportController::class, 'showForm'])->name('support.form');
Route::post('/contact-support', [SupportController::class, 'submitForm'])->name('support.submit');


Route::post('/set-currency', [CurrencyController::class, 'set'])->name('currency.set');

// Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard'); // or wherever you want to redirect
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/', function () {
    $latestProducts = \App\Models\Product::where('status', 'published')
                    ->latest()
                    ->take(6)
                    ->get();
    $freeProducts = \App\Models\Product::where('price', 0)
        ->where('status', 'published')
        ->latest()
        ->paginate(3, ['*'], 'free_page');
    $userCount = \App\Models\User::count();
    $featuredProduct = \App\Models\Product::withCount('orderItems')
                        ->orderByDesc('order_items_count')
                        ->first();

    return view('welcome',  compact('latestProducts', 'userCount', 'featuredProduct', 'freeProducts'));
})->name('home');

Route::view('/about', 'about')->name('about');
Route::get('/the-ascend', [PostController::class, 'index'])->name('ascend.index');
Route::get('/users/{username}', [ProfileController::class, 'show'])->name('profile.show');
Route::view('/return-policy', 'return-policy')->name('return.policy');
Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
Route::view('/terms', 'terms')->name('terms');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/checkout/{product}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{product}', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/{product}/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/products/{product}/reviews/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/products/{product}/reviews', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/products/{product}/reviews', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::resource('journal', JournalEntryController::class);
    Route::post('/trix-upload', function (Request $request) {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('trix_images', 'public');

        return response()->json([
            'url' => Storage::url($path),
        ]);
    });
    Route::post('/journey', [PostController::class, 'store'])->name('journey.store');
    Route::delete('/journey/{post}', [PostController::class, 'destroy'])->name('journey.destroy');
    Route::post('/posts/{post}/like', [PostController::class, 'toggle'])->name('posts.like');
    Route::post('/users/{user}/follow', [ProfileController::class, 'toggle'])->name('users.follow');
    Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->middleware('auth')->name('comments.store');
    Route::get('/posts/{post}/comments', [PostController::class, 'indexComments']);

});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalProducts' => \App\Models\Product::count(),
            'totalOrders' => \App\Models\Order::count(),
            'totalUsers' => \App\Models\User::count(),
            'totalDownloads' => \App\Models\DownloadLog::count(), // or your custom logic
        ]);
    })->name('dashboard');

    // Products
    Route::resource('/products', \App\Http\Controllers\Admin\ProductController::class);

    // Categories
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class);

    // Orders
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');

    // Download Logs
    Route::get('/download-logs', [App\Http\Controllers\Admin\DownloadLogController::class, 'index'])->name('download_logs.index');


});

Route::get('/products', [ProductPageController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductPageController::class, 'show'])->name('products.show');

// For free products
Route::get('/download/free/{product}', [DownloadController::class, 'downloadFree'])
    ->middleware(['auth', 'verified'])
    ->name('download.free');

Route::get('/download/{order}/{product}', [DownloadController::class, 'download'])
    ->middleware(['auth', 'verified', 'signed'])
    ->name('download.file');

require __DIR__.'/auth.php';
