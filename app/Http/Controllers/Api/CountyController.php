<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\County;
use Illuminate\Http\Request;

class CountyController extends Controller
{
    public function index()
    {
        return County::orderBy('name')->get();
    }

    public function getCities(County $county, Request $request)
    {
        $showAll = $request->input('show_all', false);
    
        if ($showAll) {
            $cities = $county->cities()->get(); // Retrieve all data without pagination
        } else {
            // Your existing pagination logic
            $perPage = $request->input('per_page', 10);
            $cities = $county->cities()->paginate($perPage);
        }
    
        return response()->json($cities);
    }
}
