<?php

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\CityType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_city_type_has_many_cities()
    {
        $cityType = CityType::factory()->create();
        $city1 = City::factory()->create(['city_type_id' => $cityType->id]);
        $city2 = City::factory()->create(['city_type_id' => $cityType->id]);

        $cities = $cityType->cities;

        $this->assertInstanceOf(Collection::class, $cities);
        $this->assertCount(2, $cities);
        $this->assertTrue($cities->contains($city1));
        $this->assertTrue($cities->contains($city2));
    }
}
