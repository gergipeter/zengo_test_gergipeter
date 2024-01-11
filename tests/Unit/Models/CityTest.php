<?php

namespace Tests\Unit\Models;

use Database\Factories\CityFactory;
use Database\Factories\CityTypeFactory;
use Database\Factories\CountyFactory;
use Tests\TestCase;
use App\Models\City;
use App\Models\County;
use App\Models\CityType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_a_county()
    {
        $county = CountyFactory::new()->create();
        $city = CityFactory::new()->create(['county_id' => $county->id]);

        $this->assertInstanceOf(County::class, $city->county);
        $this->assertEquals($county->id, $city->county->id);
    }

    public function test_it_belongs_to_a_city_type()
    {
        $cityType = CityTypeFactory::new()->create();
        $city = City::factory()->create(['city_type_id' => $cityType->id]);

        $this->assertInstanceOf(CityType::class, $city->cityType);
        $this->assertEquals($cityType->id, $city->cityType->id);
    }

    public function test_it_has_fillable_attributes()
    {
        $fillable = ['name', 'county_id', 'city_type_id'];
        $city = City::factory()->create();

        $this->assertEquals($fillable, $city->getFillable());
    }
}
