<?php

namespace Database\Factories;

use App\Models\CityType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CityType>
 */
class CityTypeFactory extends Factory
{
    protected $model = CityType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [
            ['name' => 'megyei jogú város', 'priority' => 4],
            ['name' => 'nagyközség', 'priority' => 6],
            ['name' => 'főváros', 'priority' => 1],
            ['name' => 'fővárosi kerület', 'priority' => 2],
            ['name' => 'község', 'priority' => 7],
            ['name' => 'megyeszékhely', 'priority' => 3],
            ['name' => 'város', 'priority' => 5],
        ];

        return $this->faker->randomElement($types);
    }
}
