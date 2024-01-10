<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'county_id', 'city_type_id'];

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function cityType()
    {
        return $this->belongsTo(CityType::class);
    }
}
