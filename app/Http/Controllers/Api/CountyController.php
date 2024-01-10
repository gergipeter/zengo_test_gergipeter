<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\County;
use Illuminate\Http\Request;

class CountyController extends Controller
{
    public function index()
    {
        return County::all();
    }

    public function getCities(County $county)
    {
        return $county->cities;
    }
}
