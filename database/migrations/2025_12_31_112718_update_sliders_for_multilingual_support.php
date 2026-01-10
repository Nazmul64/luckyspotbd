<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Check if table exists first
        if (!Schema::hasTable('sliders')) {
            return; // exit if sliders table does not exist
        }

        // ✅ Add JSON columns if not exist
        Schema::table('sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('sliders', 'title_ml')) {
                $table->json('title_ml')->nullable()->after('title');
            }
            if (!Schema::hasColumn('sliders', 'description_ml')) {
                $table->json('description_ml')->nullable()->after('description');
            }
        });

        // ✅ Migrate existing data
        $sliders = DB::table('sliders')->get();
        foreach ($sliders as $slider) {
            DB::table('sliders')
                ->where('id', $slider->id)
                ->update([
                    'title_ml' => json_encode([
                        'en' => $slider->title ?? '',
                        'bn' => $slider->title ?? '',
                    ]),
                    'description_ml' => json_encode([
                        'en' => $slider->description ?? '',
                        'bn' => $slider->description ?? '',
                    ]),
                ]);
        }

        // ✅ Drop old columns safely
        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'title') && Schema::hasColumn('sliders', 'description')) {
                $table->dropColumn(['title', 'description']);
            }
        });

        // ✅ Rename new columns to original names
        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'title_ml')) {
                $table->renameColumn('title_ml', 'title');
            }
            if (Schema::hasColumn('sliders', 'description_ml')) {
                $table->renameColumn('description_ml', 'description');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('sliders')) return;

        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'title')) {
                $table->renameColumn('title', 'title_ml');
            }
            if (Schema::hasColumn('sliders', 'description')) {
                $table->renameColumn('description', 'description_ml');
            }
        });

        Schema::table('sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('sliders', 'title')) {
                $table->string('title')->nullable()->after('id');
            }
            if (!Schema::hasColumn('sliders', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
        });

        $sliders = DB::table('sliders')->get();
        foreach ($sliders as $slider) {
            $title = json_decode($slider->title_ml, true);
            $description = json_decode($slider->description_ml, true);

            DB::table('sliders')
                ->where('id', $slider->id)
                ->update([
                    'title' => $title['en'] ?? '',
                    'description' => $description['en'] ?? '',
                ]);
        }

        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'title_ml') || Schema::hasColumn('sliders', 'description_ml')) {
                $table->dropColumn(['title_ml', 'description_ml']);
            }
        });
    }
};
