<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lottery_results', function (Blueprint $table) {
            $table->id();

            // Relation to user_package_buy
            $table->foreignId('user_package_buy_id')->constrained('userpackagebuys')->cascadeOnDelete();

            // Win status and amount
            $table->enum('win_status', ['won', 'lost'])->default('lost');
            $table->decimal('win_amount', 10, 2)->default(0);
            $table->decimal('gift_amount', 10, 2)->default(0);

            // User ID foreign key (nullable)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->string('position')->nullable();
            $table->timestamp('draw_date');

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lottery_results');
    }
};
