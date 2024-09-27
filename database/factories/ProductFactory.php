<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'code' => strtoupper(Str::random(5)), // Kode acak dengan 5 karakter huruf kapital
            'name' => $this->faker->word(), // Nama produk acak
            'abbreviation' => strtoupper($this->faker->lexify('???')), // Abreviasi dengan 3 karakter huruf acak
        ];
    }
}