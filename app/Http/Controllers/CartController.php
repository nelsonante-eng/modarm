<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // 🛒 Mostrar el carrito
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('shop.cart', compact('cart', 'total'));
    }

    // ➕ Agregar producto al carrito
    public function add(Request $request, Product $product)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    // ❌ Eliminar producto del carrito
    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            Session::put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito');
    }

    // 💰 Vista del pago
    public function checkout()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Tu carrito está vacío');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('shop.checkout', compact('cart', 'total'));
    }

    // ⚙️ Procesar el pago y guardar orden real
    public function process(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Tu carrito está vacío');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // 🧾 Crear la orden
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $validated['name'],
            'customer_email' => Auth::user()->email ?? null,
            'total' => $total,
            'payment_method' => $validated['payment_method'],
            'status' => 'paid',
        ]);

        // 📦 Registrar productos
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // 🔽 Reducir stock
            $product = Product::find($item['id']);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        // 🧹 Vaciar carrito
        Session::forget('cart');

        // ✅ Redirigir a confirmación
        return view('shop.success', [
            'name' => $validated['name'],
            'total' => $total,
            'payment_method' => ucfirst($validated['payment_method']),
        ]);
    }
}
