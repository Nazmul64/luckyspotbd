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
        Schema::create('lotteries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('price')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->decimal('first_prize')->nullable();
            $table->decimal('second_prize')->nullable();
            $table->decimal('third_prize')->nullable();
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');
            $table->date('draw_date')->nullable();

            // -----------------------------
            // 🔥 WIN TYPE ENUM CLEAN VERSION
            // -----------------------------
            $winTypes = [
                'daily',

                // Fixed Periods
                'weekly',
                'biweekly',
                'monthly',
                'quarterly',
                'halfyearly',
                'yearly',
            ];

            // Add 1–30 days dynamically
            for ($i = 1; $i <= 30; $i++) {
                $winTypes[] = $i . 'days';
            }

            $table->enum('win_type', $winTypes)->default('daily');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotteries');
    }
};
