<?php

namespace Database\Factories;

use App\Models\CityType;
use App\Models\County;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city,
            'county_id' => function () {
                return County::factory()->create()->id;
            },
            'city_type_id' => function () {
                return CityType::factory()->create()->id;
            },
        ];
    }
}
