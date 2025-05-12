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
        if (!Schema::hasTable('coordinates')) {
            Schema::create('coordinates', function (Blueprint $table) {
                $table->id();
                $table->text('place_name');
                $table->float('lat');
                $table->float('lon');
                $table->timestamps();

                $table->unique('lat', 'lon');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinates');
    }
};
