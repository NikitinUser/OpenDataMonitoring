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
        if (!Schema::hasTable('coordinate_temperatures')) {
            Schema::create('coordinate_temperatures', function (Blueprint $table) {
                $table->id();
                $table->foreignId('coordinate_id')->constrained()->cascadeOnDelete();
                $table->float('temp_cels');
                $table->dateTime('temp_datetime');
                $table->text('source');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinate_temperatures');
    }
};
