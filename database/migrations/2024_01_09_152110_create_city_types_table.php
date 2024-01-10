<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('city_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('priority');
        });

        // Insert initial data
        DB::table('city_types')->insert([
            ['name' => 'megyei jogú város', 'priority' => 4],
            ['name' => 'nagyközség', 'priority' => 6],
            ['name' => 'főváros', 'priority' => 1],
            ['name' => 'fővárosi kerület', 'priority' => 2],
            ['name' => 'község', 'priority' => 7],
            ['name' => 'megyeszékhely', 'priority' => 3],
            ['name' => 'város', 'priority' => 5],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_types');
    }
};
