<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Check if table exists
        if (!Schema::hasTable('whychooseustickets')) {
            return;
        }

        // Step 1: Add temporary JSON columns
        Schema::table('whychooseustickets', function (Blueprint $table) {
            if (!Schema::hasColumn('whychooseustickets', 'main_title_ml')) {
                $table->json('main_title_ml')->nullable()->after('main_title');
            }
            if (!Schema::hasColumn('whychooseustickets', 'main_description_ml')) {
                $table->json('main_description_ml')->nullable()->after('main_description');
            }
            if (!Schema::hasColumn('whychooseustickets', 'title_ml')) {
                $table->json('title_ml')->nullable()->after('title');
            }
            if (!Schema::hasColumn('whychooseustickets', 'description_ml')) {
                $table->json('description_ml')->nullable()->after('description');
            }
        });

        // Step 2: Migrate existing data
        $tickets = DB::table('whychooseustickets')->get();

        foreach ($tickets as $ticket) {
            DB::table('whychooseustickets')
                ->where('id', $ticket->id)
                ->update([
                    'main_title_ml' => json_encode([
                        'en' => $ticket->main_title ?? '',
                        'bn' => $ticket->main_title ?? '',
                    ]),
                    'main_description_ml' => json_encode([
                        'en' => $ticket->main_description ?? '',
                        'bn' => $ticket->main_description ?? '',
                    ]),
                    'title_ml' => json_encode([
                        'en' => $ticket->title ?? '',
                        'bn' => $ticket->title ?? '',
                    ]),
                    'description_ml' => json_encode([
                        'en' => $ticket->description ?? '',
                        'bn' => $ticket->description ?? '',
                    ]),
                ]);
        }

        // Step 3: Drop old columns
        Schema::table('whychooseustickets', function (Blueprint $table) {
            if (Schema::hasColumn('whychooseustickets', 'main_title')) {
                $table->dropColumn(['main_title', 'main_description', 'title', 'description']);
            }
        });

        // Step 4: Rename new columns to original names
        Schema::table('whychooseustickets', function (Blueprint $table) {
            if (Schema::hasColumn('whychooseustickets', 'main_title_ml')) {
                $table->renameColumn('main_title_ml', 'main_title');
            }
            if (Schema::hasColumn('whychooseustickets', 'main_description_ml')) {
                $table->renameColumn('main_description_ml', 'main_description');
            }
            if (Schema::hasColumn('whychooseustickets', 'title_ml')) {
                $table->renameColumn('title_ml', 'title');
            }
            if (Schema::hasColumn('whychooseustickets', 'description_ml')) {
                $table->renameColumn('description_ml', 'description');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('whychooseustickets')) {
            return;
        }

        // Step 1: Rename columns back
        Schema::table('whychooseustickets', function (Blueprint $table) {
            if (Schema::hasColumn('whychooseustickets', 'main_title')) {
                $table->renameColumn('main_title', 'main_title_ml');
            }
            if (Schema::hasColumn('whychooseustickets', 'main_description')) {
                $table->renameColumn('main_description', 'main_description_ml');
            }
            if (Schema::hasColumn('whychooseustickets', 'title')) {
                $table->renameColumn('title', 'title_ml');
            }
            if (Schema::hasColumn('whychooseustickets', 'description')) {
                $table->renameColumn('description', 'description_ml');
            }
        });

        // Step 2: Add old columns back
        Schema::table('whychooseustickets', function (Blueprint $table) {
            if (!Schema::hasColumn('whychooseustickets', 'main_title')) {
                $table->string('main_title')->nullable()->after('id');
            }
            if (!Schema::hasColumn('whychooseustickets', 'main_description')) {
                $table->text('main_description')->nullable()->after('main_title');
            }
            if (!Schema::hasColumn('whychooseustickets', 'title')) {
                $table->string('title')->nullable()->after('main_description');
            }
            if (!Schema::hasColumn('whychooseustickets', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
        });

        // Step 3: Migrate data back
        $tickets = DB::table('whychooseustickets')->get();

        foreach ($tickets as $ticket) {
            $mainTitle = json_decode($ticket->main_title_ml, true);
            $mainDescription = json_decode($ticket->main_description_ml, true);
            $title = json_decode($ticket->title_ml, true);
            $description = json_decode($ticket->description_ml, true);

            DB::table('whychooseustickets')
                ->where('id', $ticket->id)
                ->update([
                    'main_title' => $mainTitle['en'] ?? '',
                    'main_description' => $mainDescription['en'] ?? '',
                    'title' => $title['en'] ?? '',
                    'description' => $description['en'] ?? '',
                ]);
        }

        // Step 4: Drop JSON columns
        Schema::table('whychooseustickets', function (Blueprint $table) {
            if (Schema::hasColumn('whychooseustickets', 'main_title_ml')) {
                $table->dropColumn(['main_title_ml', 'main_description_ml', 'title_ml', 'description_ml']);
            }
        });
    }
};
