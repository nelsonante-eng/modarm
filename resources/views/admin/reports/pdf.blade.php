<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General - RM Panel</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #f97316;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #f97316;
            font-size: 24px;
            margin: 0;
        }
        .info {
            text-align: right;
            font-size: 11px;
            color: #666;
            margin-bottom: 10px;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
        .card {
            width: 32%;
            border: 1px solid #ddd;
            border-left: 5px solid #f97316;
            padding: 10px;
            border-radius: 6px;
            background-color: #fafafa;
        }
        .card h3 {
            margin: 0;
            color: #555;
            font-size: 14px;
        }
        .card p {
            margin: 5px 0 0 0;
            font-size: 18px;
            color: #f97316;
            font-weight: bold;
        }
        .section-title {
            color: #f97316;
            border-bottom: 2px solid #f97316;
            padding-bottom: 4px;
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }
        table th {
            background-color: #f97316;
            color: #fff;
            text-align: left;
        }
        table tr:nth-child(even) {
            background-color: #f8f8f8;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    {{-- Encabezado --}}
    <div class="header">
        <h1>Reporte General de Actividad</h1>
        <p>RM Panel de Administración</p>
    </div>

    <div class="info">
        Fecha de generación: <strong>{{ $generated_at }}</strong>
    </div>

    {{-- Resumen general --}}
    <div class="summary">
        <div class="card">
            <h3>Usuarios Registrados</h3>
            <p>{{ number_format($users) }}</p>
        </div>
        <div class="card">
            <h3>Órdenes Totales</h3>
            <p>{{ number_format($orders) }}</p>
        </div>
        <div class="card">
            <h3>Ventas Totales</h3>
            <p>${{ number_format($sales, 2) }}</p>
        </div>
    </div>

    {{-- Tabla de productos --}}
    <h2 class="section-title">📦 Inventario de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>${{ number_format($p->price, 2) }}</td>
                    <td>{{ $p->stock }}</td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        © {{ date('Y') }} RM Panel - Reporte generado automáticamente
    </footer>

</body>
</html>
