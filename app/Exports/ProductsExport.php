<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Name',
            'Description',
            'Price',
            'Discount Percent',
            'Stock',
            'Location',
            'Shipping Time',
            'Image URL',
        ];
    }

    /**
    * @var Product $product
    */
    public function map($product): array
    {
        return [
            $product->sku,
            $product->name,
            $product->description,
            $product->price,
            $product->discount_percent,
            $product->stock,
            $product->location,
            $product->shipping_time,
            $product->image,
        ];
    }
}
