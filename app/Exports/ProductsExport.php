<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * Obtener la colección de productos desde la base de datos.
     */
    public function collection()
    {
        return Product::select('id', 'name', 'price', 'stock', 'created_at')->get();
    }

    /**
     * Encabezados de las columnas.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre del Producto',
            'Precio ($)',
            'Stock Disponible',
            'Fecha de Registro',
        ];
    }

    /**
     * Formatear los datos por fila.
     */
    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            number_format($product->price, 2),
            $product->stock,
            $product->created_at->format('d/m/Y'),
        ];
    }
}
