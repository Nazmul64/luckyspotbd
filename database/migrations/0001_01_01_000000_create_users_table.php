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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // User Role & Status
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->enum('status', ['active', 'inactive'])->default('active');

            // Extra Profile Fields
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('number')->nullable();
            $table->string('username')->nullable();
            $table->string('country')->nullable();

            // Referral
            $table->unsignedBigInteger('referred_by')->nullable()->comment('User ID who referred this user');
            $table->unsignedBigInteger('ref_id')->nullable()->comment('Alternate referral user ID');
            $table->string('ref_code')->unique()->nullable();

            // Wallet
            $table->decimal('balance', 12, 2)->default(0.00)->comment('User wallet balance');
            $table->decimal('refer_income', 12, 2)->default(0.00)->comment('Direct referral commission earned');
            $table->decimal('generation_income', 12, 2)->default(0.00)->comment('Generation level commission earned');

            // Address
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
