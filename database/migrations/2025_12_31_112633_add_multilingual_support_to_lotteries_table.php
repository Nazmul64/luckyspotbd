<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up(): void
    {
        if (!Schema::hasTable('lotteries')) return; // ✅ check table exist

        Schema::table('lotteries', function (Blueprint $table) {
            if (!Schema::hasColumn('lotteries', 'name_ml')) {
                $table->json('name_ml')->nullable()->after('name');
            }
            if (!Schema::hasColumn('lotteries', 'description_ml')) {
                $table->json('description_ml')->nullable()->after('description');
            }
        });

        $lotteries = DB::table('lotteries')->get();

        foreach ($lotteries as $lottery) {
            DB::table('lotteries')
                ->where('id', $lottery->id)
                ->update([
                    'name_ml' => json_encode([
                        'en' => $lottery->name ?? '',
                        'bn' => $lottery->name ?? ''
                    ]),
                    'description_ml' => json_encode([
                        'en' => $lottery->description ?? '',
                        'bn' => $lottery->description ?? ''
                    ]),
                ]);
        }

        Schema::table('lotteries', function (Blueprint $table) {
            if (Schema::hasColumn('lotteries', 'name') && Schema::hasColumn('lotteries', 'description')) {
                $table->dropColumn(['name', 'description']);
            }
        });

        Schema::table('lotteries', function (Blueprint $table) {
            if (Schema::hasColumn('lotteries', 'name_ml')) $table->renameColumn('name_ml', 'name');
            if (Schema::hasColumn('lotteries', 'description_ml')) $table->renameColumn('description_ml', 'description');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('lotteries')) return;

        Schema::table('lotteries', function (Blueprint $table) {
            if (Schema::hasColumn('lotteries', 'name')) $table->renameColumn('name', 'name_ml');
            if (Schema::hasColumn('lotteries', 'description')) $table->renameColumn('description', 'description_ml');
        });

        Schema::table('lotteries', function (Blueprint $table) {
            if (!Schema::hasColumn('lotteries', 'name')) $table->string('name')->nullable()->after('id');
            if (!Schema::hasColumn('lotteries', 'description')) $table->text('description')->nullable()->after('name');
        });

        $lotteries =DB::table('lotteries')->get();
        foreach ($lotteries as $lottery) {
            $name = json_decode($lottery->name_ml, true);
            $description = json_decode($lottery->description_ml, true);

            DB::table('lotteries')
                ->where('id', $lottery->id)
                ->update([
                    'name' => $name['en'] ?? '',
                    'description' => $description['en'] ?? '',
                ]);
        }

        Schema::table('lotteries', function (Blueprint $table) {
            if (Schema::hasColumn('lotteries', 'name_ml') || Schema::hasColumn('lotteries', 'description_ml')) {
                $table->dropColumn(['name_ml', 'description_ml']);
            }
        });
    }
};
