@extends('layouts.app')
@section('content')
<h2>Carrito</h2>
@if(!$cart) <p>Carrito vacío</p> @else
<form action="{{ route('cart.checkout') }}" method="POST">
  @csrf
  <table>
  <tr><th>Producto</th><th>Cant</th><th>Precio</th></tr>
  @foreach($cart as $id=>$item)
    <tr>
      <td>{{ $item['name'] }}</td>
      <td>{{ $item['quantity'] }}</td>
      <td>${{ $item['price'] * $item['quantity'] }}</td>
    </tr>
  @endforeach
  </table>
  <p>Total: ${{ collect($cart)->reduce(fn($t,$i)=>$t + $i['price']*$i['quantity'],0) }}</p>
  <input name="customer_name" placeholder="Nombre">
  <input name="customer_email" placeholder="Email">
  <button type="submit">Proceder al pago (simulado)</button>
</form>
@endif
@endsection
