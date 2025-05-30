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
        Schema::table('residuos', function (Blueprint $table) {
            $table->boolean('inflamable')->default(false);
            $table->boolean('peligroso')->default(false);
            $table->boolean('biodegradable')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residuos', function (Blueprint $table) {
            //
        });
    }
};
