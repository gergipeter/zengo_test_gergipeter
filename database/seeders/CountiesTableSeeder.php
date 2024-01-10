<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\CityType;
use App\Models\County;
use Illuminate\Database\Seeder;

class CountiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = storage_path('app/counties.txt');

        if (file_exists($filePath)) {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($lines as $line) {            
                $data = explode("\t", trim($line));
    
                $city = $data[0];
                $type = $data[1];
                $county = $data[2];
    
                $countyModel = County::firstOrCreate(['name' => $county]);
                $cityTypeModel = CityType::firstOrCreate(['name' => $type]);
    
                City::create([
                    'name' => $city,
                    'city_type_id' => $cityTypeModel->id,
                    'county_id' => $countyModel->id,
                ]);
            }
        } else {
            echo "File not found: $filePath";
        }
    }
}
