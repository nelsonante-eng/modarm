<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ProductsExport;

class ReportController extends Controller
{
    /**
     * 📊 Mostrar panel de reportes con datos reales
     */
    public function index()
    {
        // === Totales generales ===
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalSales = Order::where('status', 'paid')->sum('total');

        // === Ventas mensuales (últimos 6 meses) ===
        $monthlySales = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total) as total')
            )
            ->where('status', 'paid')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get()
            ->reverse(); // Mostrar de más antiguo a reciente

        $months = $monthlySales->map(fn($sale) => Carbon::create()->month($sale->month)->format('M'));
        $salesData = $monthlySales->pluck('total');

        // === Top 5 productos más vendidos ===
        $topProducts = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.name',
                'products.price',
                'products.stock',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy('products.id', 'products.name', 'products.price', 'products.stock')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // === Distribución de stock por producto ===
        $stockLabels = Product::pluck('name');
        $stockData = Product::pluck('stock');

        // === Datos de ventas para gráficos ===
        $chartData = [
            'months' => $months,
            'salesData' => $salesData,
            'stockLabels' => $stockLabels,
            'stockData' => $stockData,
        ];

        return view('admin.reports.index', compact(
            'totalUsers',
            'totalProducts',
            'totalSales',
            'topProducts',
            'chartData'
        ));
    }

    /**
     * 📄 Exportar reporte completo en PDF
     */
    public function exportPDF()
    {
        $ordersCount = Order::count();
        $salesSum = Order::where('status', 'paid')->sum('total');
        $products = Product::all();

        $data = [
            'users' => User::count(),
            'products' => $products,
            'orders' => $ordersCount,
            'sales' => $salesSum,
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('admin.reports.pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('reporte-general.pdf');
    }

    /**
     * 📊 Exportar productos a Excel
     */
    public function exportExcel()
    {
        $fileName = 'reporte_productos_' . now()->format('Y_m_d_His') . '.xlsx';
        return Excel::download(new ProductsExport, $fileName);
    }
}
