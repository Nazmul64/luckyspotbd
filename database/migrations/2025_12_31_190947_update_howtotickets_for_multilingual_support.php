<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('howtotickets')) {
            // Create table if it doesn't exist
            Schema::create('howtotickets', function (Blueprint $table) {
                $table->id();
                $table->json('title')->nullable();
                $table->json('description')->nullable();
                $table->json('sign_up_first_login')->nullable();
                $table->json('complete_your_profile')->nullable();
                $table->json('choose_a_ticket')->nullable();
                $table->string('sign_up_first_login_icon')->nullable();
                $table->string('complete_your_profile_icon')->nullable();
                $table->string('choose_a_ticket_icon')->nullable();
                $table->timestamps();
            });
            return;
        }

        // If table exists, modify columns
        Schema::table('howtotickets', function (Blueprint $table) {
            $columns = ['title', 'description', 'sign_up_first_login', 'complete_your_profile', 'choose_a_ticket'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('howtotickets', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('howtotickets', function (Blueprint $table) {
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->json('sign_up_first_login')->nullable();
            $table->json('complete_your_profile')->nullable();
            $table->json('choose_a_ticket')->nullable();

            // Add icon columns if they don't exist
            if (!Schema::hasColumn('howtotickets', 'sign_up_first_login_icon')) {
                $table->string('sign_up_first_login_icon')->nullable();
            }
            if (!Schema::hasColumn('howtotickets', 'complete_your_profile_icon')) {
                $table->string('complete_your_profile_icon')->nullable();
            }
            if (!Schema::hasColumn('howtotickets', 'choose_a_ticket_icon')) {
                $table->string('choose_a_ticket_icon')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('howtotickets')) {
            return;
        }

        Schema::table('howtotickets', function (Blueprint $table) {
            $columns = ['title', 'description', 'sign_up_first_login', 'complete_your_profile', 'choose_a_ticket'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('howtotickets', $column)) {
                    $table->dropColumn($column);
                }
            }

            // Recreate as string/text columns
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('sign_up_first_login')->nullable();
            $table->text('complete_your_profile')->nullable();
            $table->text('choose_a_ticket')->nullable();
        });
    }
};
