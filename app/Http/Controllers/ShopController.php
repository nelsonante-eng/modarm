<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 🏷️ Filtro por categoría (insensible a mayúsculas/minúsculas)
        if ($request->filled('category')) {
            $query->whereRaw('LOWER(category) = ?', [strtolower(trim($request->category))]);
        }

        // 🔍 Filtro por nombre
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Solo productos con stock disponibles
        $products = $query->where('stock', '>', 0)
                          ->orderBy('id', 'desc')
                          ->paginate(12);

        // Lista de categorías
        $categories = ['Ropa', 'Calzado', 'Accesorios'];

        return view('shop.index', compact('products', 'categories'));
    }
}
