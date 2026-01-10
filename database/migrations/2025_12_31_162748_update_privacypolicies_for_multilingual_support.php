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
        // Check if table exists
        if (!Schema::hasTable('privacypolicies')) {
            return;
        }

        Schema::table('privacypolicies', function (Blueprint $table) {
            // Add multilingual JSON fields
            if (!Schema::hasColumn('privacypolicies', 'title')) {
                $table->json('title')->nullable()->after('id');
                // Example: {"en":"Privacy Policy","bn":"প্রাইভেসি পলিসি"}
            }

            if (!Schema::hasColumn('privacypolicies', 'description')) {
                $table->json('description')->nullable()->after('title');
                // Example: {"en":"We respect your privacy","bn":"আমরা আপনার গোপনীয়তা সম্মান করি"}
            }

            // No question & answer columns will be added
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if table exists
        if (!Schema::hasTable('privacypolicies')) {
            return;
        }

        Schema::table('privacypolicies', function (Blueprint $table) {
            // Drop multilingual columns
            if (Schema::hasColumn('privacypolicies', 'title')) {
                $table->dropColumn('title');
            }

            if (Schema::hasColumn('privacypolicies', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
