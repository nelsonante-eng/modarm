@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->name }}</h1>
    <p>Precio: {{ $product->price }}</p>
</div>
@endsection
