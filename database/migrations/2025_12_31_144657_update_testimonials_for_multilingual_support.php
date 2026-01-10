<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('testimonials')) {
            return;
        }

        Schema::table('testimonials', function (Blueprint $table) {
            // multilingual JSON fields
            if (!Schema::hasColumn('testimonials', 'name')) {
                $table->json('name')->nullable()->after('id'); // {"en":"John","bn":"জন"}
            }
            if (!Schema::hasColumn('testimonials', 'designation')) {
                $table->json('designation')->nullable()->after('name'); // {"en":"Manager","bn":"ম্যানেজার"}
            }
            if (!Schema::hasColumn('testimonials', 'message')) {
                $table->json('message')->nullable()->after('designation'); // {"en":"Great service","bn":"দারুন সেবা"}
            }
            if (!Schema::hasColumn('testimonials', 'title')) {
                $table->json('title')->nullable()->after('message'); // {"en":"Feedback","bn":"মতামত"}
            }
            if (!Schema::hasColumn('testimonials', 'description')) {
                $table->json('description')->nullable()->after('title'); // {"en":"Our clients","bn":"আমাদের ক্লায়েন্টরা"}
            }

            // **question & answer কোন কলাম থাকবে না, আর drop করতেও হবে না**
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('testimonials')) {
            return;
        }

        Schema::table('testimonials', function (Blueprint $table) {
            // Drop multilingual columns
            $table->dropColumn(['name', 'designation', 'message', 'title', 'description']);
        });
    }
};
