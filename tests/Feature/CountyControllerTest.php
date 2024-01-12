<?php

namespace Tests\Feature;

use App\Models\County;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_get_all_cities_for_county()
    {
        $county = County::factory()->create();
        $cities = $county->cities()->get();

        $response = $this->getJson("/api/counties/{$county->id}/cities?show_all=true");

        $response->assertSuccessful()
            ->assertJson($cities->toArray());
    }
}
