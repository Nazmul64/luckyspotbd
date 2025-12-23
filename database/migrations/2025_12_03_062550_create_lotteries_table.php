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

            // Basic Info
            $table->string('name');
            $table->decimal('price', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('photo')->nullable();

            // Prizes
            $table->decimal('first_prize', 15, 2)->nullable()->default(0);
            $table->decimal('second_prize', 15, 2)->nullable()->default(0);
            $table->decimal('third_prize', 15, 2)->nullable()->default(0);

            // Multiple packages - stored as JSON
            $table->json('multiple_title')->nullable();
            $table->json('multiple_price')->nullable();

            // Video settings
            $table->string('video_url', 500)->nullable();
            $table->boolean('video_enabled')->default(false);
            $table->dateTime('video_scheduled_at')->nullable();

            // Draw settings
            $table->dateTime('draw_date');
            $table->string('win_type', 50);
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');

            $table->timestamps();

            // Indexes for better performance
            $table->index('status');
            $table->index('draw_date');
            $table->index(['status', 'draw_date']);
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
