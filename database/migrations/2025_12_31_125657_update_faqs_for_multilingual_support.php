<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Check table exists
        if (!Schema::hasTable('faqs')) {
            return;
        }

        // Step 1: Add temporary JSON columns for question, answer, title, description
        Schema::table('faqs', function (Blueprint $table) {
            if (!Schema::hasColumn('faqs', 'question_ml')) {
                $table->json('question_ml')->nullable()->after('id');
            }
            if (!Schema::hasColumn('faqs', 'answer_ml')) {
                $table->json('answer_ml')->nullable()->after('question_ml');
            }
            if (!Schema::hasColumn('faqs', 'title_ml')) {
                $table->json('title_ml')->nullable()->after('answer_ml');
            }
            if (!Schema::hasColumn('faqs', 'description_ml')) {
                $table->json('description_ml')->nullable()->after('title_ml');
            }
        });

        // Step 2: Migrate existing data into JSON columns
        $faqs = DB::table('faqs')->get();

        foreach ($faqs as $faq) {
            DB::table('faqs')
                ->where('id', $faq->id)
                ->update([
                    'question_ml' => json_encode([
                        'en' => $faq->question ?? '',
                        'bn' => $faq->question ?? '',
                    ]),
                    'answer_ml' => json_encode([
                        'en' => $faq->answer ?? '',
                        'bn' => $faq->answer ?? '',
                    ]),
                    'title_ml' => json_encode([
                        'en' => $faq->title ?? '',
                        'bn' => $faq->title ?? '',
                    ]),
                    'description_ml' => json_encode([
                        'en' => $faq->description ?? '',
                        'bn' => $faq->description ?? '',
                    ]),
                ]);
        }

        // Step 3: Drop old columns
        Schema::table('faqs', function (Blueprint $table) {
            $oldColumns = ['question', 'answer', 'title', 'description'];
            foreach ($oldColumns as $col) {
                if (Schema::hasColumn('faqs', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        // Step 4: Rename temporary JSON columns to final names
        Schema::table('faqs', function (Blueprint $table) {
            $table->renameColumn('question_ml', 'question');
            $table->renameColumn('answer_ml', 'answer');
            $table->renameColumn('title_ml', 'title');
            $table->renameColumn('description_ml', 'description');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('faqs')) {
            return;
        }

        // Step 1: Rename JSON columns back to temporary names
        Schema::table('faqs', function (Blueprint $table) {
            $table->renameColumn('question', 'question_ml');
            $table->renameColumn('answer', 'answer_ml');
            $table->renameColumn('title', 'title_ml');
            $table->renameColumn('description', 'description_ml');
        });

        // Step 2: Add old string/text columns back
        Schema::table('faqs', function (Blueprint $table) {
            if (!Schema::hasColumn('faqs', 'question')) {
                $table->string('question')->nullable()->after('id');
            }
            if (!Schema::hasColumn('faqs', 'answer')) {
                $table->text('answer')->nullable()->after('question');
            }
            if (!Schema::hasColumn('faqs', 'title')) {
                $table->string('title')->nullable()->after('answer');
            }
            if (!Schema::hasColumn('faqs', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
        });

        // Step 3: Migrate data back from JSON
        $faqs = DB::table('faqs')->get();

        foreach ($faqs as $faq) {
            $question = json_decode($faq->question_ml, true);
            $answer = json_decode($faq->answer_ml, true);
            $title = json_decode($faq->title_ml, true);
            $description = json_decode($faq->description_ml, true);

            DB::table('faqs')
                ->where('id', $faq->id)
                ->update([
                    'question' => $question['en'] ?? '',
                    'answer' => $answer['en'] ?? '',
                    'title' => $title['en'] ?? '',
                    'description' => $description['en'] ?? '',
                ]);
        }

        // Step 4: Drop temporary JSON columns
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn(['question_ml', 'answer_ml', 'title_ml', 'description_ml']);
        });
    }
};
