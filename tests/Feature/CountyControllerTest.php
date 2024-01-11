<?php

namespace Tests\Feature;

use App\Models\County;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_get_counties_in_order()
    {
        $counties = County::factory()->count(5)->create();

        $response = $this->getJson('/api/counties');

        $response->assertSuccessful()
            ->assertJsonCount(5, 'data')
            ->assertJson([
                'data' => $counties->sortBy('name')->map->only(['id', 'name'])->values()->toArray(),
            ]);
    }

    public function test_it_can_get_cities_for_county_with_pagination()
    {
        $county = County::factory()->create();
        $cities = $county->cities()->paginate(10);

        $response = $this->getJson("/api/counties/{$county->id}/cities");

        $response->assertSuccessful()
            ->assertJson($cities->toArray());
    }

    public function test_it_can_get_all_cities_for_county()
    {
        $county = County::factory()->create();
        $cities = $county->cities()->get();

        $response = $this->getJson("/api/counties/{$county->id}/cities?show_all=true");

        $response->assertSuccessful()
            ->assertJson($cities->toArray());
    }
}
