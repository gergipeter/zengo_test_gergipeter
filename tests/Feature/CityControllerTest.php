<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\County;
use App\Models\CityType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_can_store_a_new_city()
    {
        $county = County::factory()->create();
        $cityType = CityType::factory()->create();

        $data = [
            'name' => $this->faker->city,
            'countyId' => $county->id,
            'cityTypeId' => $cityType->id,
        ];

        $response = $this->postJson(route('cities.store'), $data);

        $response->assertStatus(201)
                 ->assertJson(['id' => true, 'name' => $data['name']]);
    }

    public function test_it_can_update_a_city()
    {
        $city = City::factory()->create();

        $data = [
            'name' => $this->faker->city,
        ];
    
        $response = $this->putJson(route('cities.update', ['city' => $city->id]), $data);
    
        $response->assertStatus(200)
                 ->assertJson(['id' => $city->id, 'name' => $data['name']]);
    }

    public function test_it_can_delete_a_city()
    {
        $city = City::factory()->create();

        $response = $this->deleteJson(route('cities.destroy', ['city' => $city->id]));

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertNull(City::find($city->id));
    }
}
