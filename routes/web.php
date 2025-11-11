<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Página principal
Route::get('/', function () {
    return view('welcome');
});

// 🔒 Panel de administración
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/pdf', [ReportController::class, 'exportPDF'])->name('reports.pdf');
    Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
    Route::resource('users', UserController::class);
});

// 👤 Dashboard de usuario
Route::middleware(['auth'])->get('/user/dashboard', function () {
    return view('shop.user-dashboard');
})->name('user.dashboard');

// 🧾 Mis pedidos del usuario autenticado
Route::middleware(['auth'])->get('/user/orders', [OrderController::class, 'index'])->name('user.orders');

// 🧍 Perfil de usuario
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🛍️ Tienda pública + filtros
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// 🛒 Carrito de compras
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout/process', [CartController::class, 'process'])->name('checkout.process');
});

// 🧭 Ruta de compatibilidad con Breeze para los tests
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // usuario normal → redirige aquí, pero Breeze ve /dashboard
    return redirect('/user/dashboard');
})->name('dashboard');

// 🔐 Autenticación Breeze
require __DIR__ . '/auth.php';
