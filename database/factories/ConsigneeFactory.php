<?php

namespace Database\Factories;

use App\Models\Consignee;
use App\Models\Clients;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsigneeFactory extends Factory
{
    protected $model = Consignee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'tel' => $this->faker->phoneNumber,
            'id_client' => Clients::factory(),
        ];
    }
}
