<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'countyId' => 'required|exists:counties,id',
            'cityTypeId' => 'required|exists:city_types,id',
        ]);

        $city = City::create([
            'name' => $request->input('name'),
            'county_id' => $request->input('countyId'),
            'city_type_id' => $request->input('cityTypeId'),
        ]);

        return response()->json(['id' => $city->id, 'name' => $city->name], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'string|max:255',
        ]);

        $updatedName = $request->input('name');

        $city = City::findOrFail($id);
        $city->update(['name' => $updatedName]);

        return response()->json(['id' => $city->id, 'name' => $city->name], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json(['success' => true]);
    }
}
