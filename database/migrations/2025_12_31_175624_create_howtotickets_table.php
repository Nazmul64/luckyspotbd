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
        Schema::create('howtotickets', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description');
            $table->text('sign_up_first_login');
            $table->text('complete_your_profile');
            $table->text('choose_a_ticket');
            $table->text('sign_up_first_login_icon');
            $table->text('complete_your_profile_icon');
            $table->text('choose_a_ticket_icon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('howtotickets');
    }
};
