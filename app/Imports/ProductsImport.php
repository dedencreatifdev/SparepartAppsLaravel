<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Product::updateOrCreate(
            ['sku' => $row['sku']],
            [
                'name'             => $row['name'],
                'description'      => $row['description'] ?? null,
                'price'            => $row['price'],
                'discount_percent' => $row['discount_percent'] ?? 0,
                'discount_amount'  => ($row['price'] * ($row['discount_percent'] ?? 0)) / 100,
                'stock'            => $row['stock'] ?? 0,
                'location'         => $row['location'] ?? null,
                'shipping_time'    => $row['shipping_time'] ?? null,
                'image'            => $row['image_url'] ?? null,
            ]
        );
    }
}
