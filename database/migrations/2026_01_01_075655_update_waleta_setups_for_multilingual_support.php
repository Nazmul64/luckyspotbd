<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only proceed if table exists
        if (!Schema::hasTable('waleta_setups')) {
            return;
        }

        Schema::table('waleta_setups', function (Blueprint $table) {

            // Bank Name (Multilingual)
            if (!Schema::hasColumn('waleta_setups', 'bankname')) {
                $table->json('bankname')
                      ->nullable()
                      ->after('id');
                // Example: {"en":"DBBL","bn":"ডাচ বাংলা ব্যাংক"}
            }

            // Account Number (Multilingual)
            if (!Schema::hasColumn('waleta_setups', 'accountnumber')) {
                $table->json('accountnumber')
                      ->nullable()
                      ->after('bankname');
                // Example: {"en":"123456789","bn":"১২৩৪৫৬৭৮৯"}
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('waleta_setups')) {
            return;
        }

        Schema::table('waleta_setups', function (Blueprint $table) {

            if (Schema::hasColumn('waleta_setups', 'accountnumber')) {
                $table->dropColumn('accountnumber');
            }

            if (Schema::hasColumn('waleta_setups', 'bankname')) {
                $table->dropColumn('bankname');
            }
        });
    }
};
