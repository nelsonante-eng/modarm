@extends('layouts.app')
@section('content')
<h2>Comprobante: Orden #{{ $order->id }}</h2>
<p>Cliente: {{ $order->customer_name }} - {{ $order->customer_email }}</p>
<p>Total: ${{ $order->total }}</p>
<p>Estado: {{ $order->status }}</p>
<ul>
@foreach($order->items as $it)
  <li>{{ $it->product->name }} x{{ $it->quantity }} - ${{ $it->price }}</li>
@endforeach
</ul>
@endsection
