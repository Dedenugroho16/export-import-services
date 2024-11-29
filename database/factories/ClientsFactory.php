<?php

namespace Database\Factories;

use App\Models\Clients;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientsFactory extends Factory
{
    protected $model = Clients::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'PO_BOX' => $this->faker->postcode,
            'tel' => $this->faker->phoneNumber,
            'fax' => $this->faker->phoneNumber,
        ];
    }
}