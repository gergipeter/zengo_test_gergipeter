<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityType extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'priority'];

    public $timestamps = false;

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
