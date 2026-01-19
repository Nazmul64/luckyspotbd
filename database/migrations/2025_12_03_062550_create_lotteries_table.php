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

            // Basic Info (Multilingual stored as JSON)
            $table->json('name'); // {en: 'Name', bn: 'নাম'}
            $table->json('description')->nullable(); // {en: 'Description', bn: 'বর্ণনা'}
            $table->decimal('price', 15, 2)->default(0)->comment('Ticket price');
            $table->string('photo')->nullable()->comment('Lottery image');

            // Prize amounts
            $table->decimal('first_prize', 15, 2)->default(0)->comment('1st prize money');
            $table->decimal('second_prize', 15, 2)->default(0)->comment('2nd prize money');
            $table->decimal('third_prize', 15, 2)->default(0)->comment('3rd prize money');

            // Multiple packages (Best Gifts) stored as JSON
            $table->json('multiple_title')->nullable()->comment('Package names array');
            $table->json('multiple_price')->nullable()->comment('Package prices array');

            // Video settings for live draw
            $table->enum('video_type', ['upload', 'direct', 'youtube'])->default('direct')->comment('Video source type');
            $table->string('video_url')->nullable()->comment('YouTube URL or Direct URL');
            $table->string('video_file')->nullable()->comment('Uploaded video file path');
            $table->boolean('video_enabled')->default(false)->comment('Enable/disable video');
            $table->timestamp('video_scheduled_at')->nullable()->comment('When to show video');

            // Draw settings
            $table->timestamp('draw_date')->nullable()->comment('Draw date and time');
            $table->string('win_type', 50)->comment('Win frequency: daily, weekly, monthly, Ndays');
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active')->comment('Lottery status');

            // Timestamps & soft deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance optimization
            $table->index('status');
            $table->index('draw_date');
            $table->index('video_enabled');
            $table->index(['status', 'draw_date']);
            $table->index('created_at');
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
