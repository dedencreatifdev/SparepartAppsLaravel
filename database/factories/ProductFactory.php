<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->numberBetween(10000, 1000000);
        $discountPercent = $this->faker->randomElement([0, 10, 20, 30, 50, 78]);
        $discountAmount = $price * ($discountPercent / 100);

        return [
            'name' => $this->faker->words(4, true),
            'description' => $this->faker->paragraph(),
            'price' => $price,
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'stock' => $this->faker->numberBetween(0, 1000),
            'rating' => $this->faker->randomFloat(1, 3, 5),
            'sales_count' => $this->faker->numberBetween(0, 50000),
            'image' => 'https://images.unsplash.com/photo-1584992236310-6edddc08acff?auto=format&fit=crop&w=300&q=80',
            'is_star_plus' => $this->faker->boolean(30),
            'is_promo_xtra' => $this->faker->boolean(40),
            'location' => $this->faker->randomElement(['KAB. TANGERANG', 'KOTA JAKARTA U...', 'KOTA BANDUNG', 'KOTA SURABAYA']),
            'shipping_time' => $this->faker->randomElement(['2-3 Hari', '4-7 Hari', '1-2 Hari']),
        ];
    }
}
