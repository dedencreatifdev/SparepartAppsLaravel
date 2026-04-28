<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductsImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        $products = [];
        $now = now();

        foreach ($rows as $row) {
            if (!isset($row['sku']) || empty($row['sku'])) {
                continue;
            }

            $price = $row['price'] ?? 0;
            $discountPercent = $row['discount_percent'] ?? 0;

            $products[] = [
                'sku'              => (string) $row['sku'],
                'name'             => $row['name'] ?? 'No Name',
                'description'      => $row['description'] ?? $row['name'] ?? null,
                'price'            => $price,
                'discount_percent' => $discountPercent,
                'discount_amount'  => ($price * $discountPercent) / 100,
                'stock'            => $row['stock'] ?? 0,
                'location'         => $row['location'] ?? null,
                'shipping_time'    => $row['shipping_time'] ?? null,
                'image'            => $row['image_url'] ?? null,
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }

        if (!empty($products)) {
            // Upsert in batches of 100
            foreach (array_chunk($products, 100) as $chunk) {
                Product::upsert($chunk, ['sku'], [
                    'name', 'description', 'price', 'discount_percent', 'discount_amount',
                    'stock', 'location', 'shipping_time', 'image', 'updated_at'
                ]);
            }
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
