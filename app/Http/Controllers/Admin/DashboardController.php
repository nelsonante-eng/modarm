<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Mostrar el panel principal con datos reales.
     */
    public function index()
    {
        // ✅ Verificar si el usuario tiene rol de admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado. Solo administradores.');
        }

        // === TOTAL PRODUCTOS ===
        $totalProducts = Product::count();

        // === VENTAS DE HOY ===
        $salesToday = Order::whereDate('created_at', Carbon::today())
            ->sum('total');

        // === GANANCIAS DEL MES ===
        $monthlyEarnings = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total');

        // === USUARIOS REGISTRADOS ===
        $totalUsers = User::count();

        // === PRODUCTOS CON STOCK BAJO (alerta) ===
        $lowStockProducts = Product::where('stock', '<', 10)->get();

        // === ÚLTIMAS 5 ÓRDENES ===
        $recentOrders = Order::latest()->take(5)->get();

        // === Top 5 productos más vendidos ===
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // ✅ Retornar la vista con todos los datos necesarios
        return view('admin.dashboard', compact(
            'totalProducts',
            'salesToday',
            'monthlyEarnings',
            'totalUsers',
            'lowStockProducts',
            'recentOrders',
            'topProducts'
        ));
    }
}
