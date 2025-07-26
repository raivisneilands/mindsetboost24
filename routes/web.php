<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SitemapController;

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/', function () {
    $latestProducts = \App\Models\Product::latest()->take(6)->get();
    return view('welcome',  compact('latestProducts'));
})->name('home');

Route::view('/about', 'about')->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/checkout/{product}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{product}', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/{slug}/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');

});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalProducts' => \App\Models\Product::count(),
            'totalOrders' => \App\Models\Order::count(),
            'totalUsers' => \App\Models\User::count(),
            'totalDownloads' => \App\Models\OrderItem::sum('quantity'), // or your custom logic
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

Route::get('/download/{order}/{product}', [DownloadController::class, 'download'])
    ->middleware(['auth', 'signed'])
    ->name('download.file');

Route::get('/test-email', function () {
    Mail::to('test@example.com')->send(new TestEmail());
    return 'Test email sent!';
});

require __DIR__.'/auth.php';
