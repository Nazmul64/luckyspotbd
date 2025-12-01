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
        Schema::create('commission_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('refer_commission')->default(0.00)->nullable();
            $table->decimal('generation_level_1')->default(0.00)->nullable();
            $table->decimal('generation_level_2')->default(0.00)->nullable();
            $table->decimal('generation_level_3')->default(0.00)->nullable();
            $table->decimal('generation_level_4')->default(0.00)->nullable();
            $table->decimal('generation_level_5')->default(0.00)->nullable();
            // Status (1 = active, 0 = inactive)
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_settings');
    }
};
