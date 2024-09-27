<?php

namespace Database\Factories;

use App\Models\DetailProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailProductFactory extends Factory
{
    protected $model = DetailProduct::class;

    public function definition()
    {
        return [
            'id_product' => Product::factory(), // Relasi ke model Product
            'name' => $this->faker->word(), // Nama acak untuk detail produk
            'pcs' => $this->faker->numberBetween(1, 100), // Jumlah pcs acak antara 1 hingga 100
            'dimension' => sprintf('%dx%dx%d cm', $this->faker->numberBetween(10, 50), $this->faker->numberBetween(10, 50), $this->faker->numberBetween(10, 50)), // Dimensi acak dalam format 20x20x25 cm
            'type' => $this->faker->word(), // Tipe acak
            'color' => $this->faker->safeColorName(), // Warna acak
            'price' => $this->faker->randomFloat(2, 10, 5000), // Harga acak antara 10 hingga 5000 dengan 2 desimal
        ];
    }
}