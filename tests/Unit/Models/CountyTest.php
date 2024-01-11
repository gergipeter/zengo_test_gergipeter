<?php

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\County;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountyTest extends TestCase
{
    use RefreshDatabase;

    public function test_county_has_many_cities()
    {
        $county = County::factory()->create();
        $city1 = City::factory()->create(['county_id' => $county->id]);
        $city2 = City::factory()->create(['county_id' => $county->id]);

        $cities = $county->cities;

        $this->assertInstanceOf(Collection::class, $cities);
        $this->assertCount(2, $cities);
        $this->assertTrue($cities->contains($city1));
        $this->assertTrue($cities->contains($city2));
    }
}
