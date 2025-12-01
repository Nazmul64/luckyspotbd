<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdraw_commissions', function (Blueprint $table) {
            $table->id();
            $table->decimal('withdraw_commission', 10, 2);
            $table->decimal('minimum_withdraw', 10, 2);
            $table->decimal('maximum_withdraw', 10, 2);
            $table->decimal('minimum_deposite', 10, 2);
            $table->decimal('maximum_deposite', 10, 2);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdraw_commissions');
    }
};
