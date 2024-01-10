<?php

namespace Database\Factories;

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
            ['type' => 'megyei jogú város', 'priority' => 4],
            ['type' => 'nagyközség', 'priority' => 6],
            ['type' => 'főváros', 'priority' => 1],
            ['type' => 'fővárosi kerület', 'priority' => 2],
            ['type' => 'község', 'priority' => 7],
            ['type' => 'megyeszékhely', 'priority' => 3],
            ['type' => 'város', 'priority' => 5],
        ];

        return $this->faker->randomElement($types);
    }
}
