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
       if (!Schema::hasTable('userpackagebuys')) {
            Schema::create('userpackagebuys', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('package_id');
                $table->decimal('price', 8, 2);
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->string('ticket_number');
                $table->timestamp('purchased_at')->useCurrent();
                $table->timestamps();
                $table->softDeletes();
            });
}

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userpackagebuys');
    }
};
