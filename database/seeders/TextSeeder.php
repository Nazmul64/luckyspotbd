<?php

namespace Database\Seeders;

use App\Models\Text;
use Illuminate\Database\Seeder;

class TextSeeder extends Seeder
{
    public function run(): void
    {
        $texts = [
            // Navigation texts
            ['key' => 'nav_home', 'language_code' => 'en', 'value' => 'Home'],
            ['key' => 'nav_home', 'language_code' => 'bn', 'value' => 'হোম'],

            ['key' => 'nav_about', 'language_code' => 'en', 'value' => 'About'],
            ['key' => 'nav_about', 'language_code' => 'bn', 'value' => 'সম্পর্কে'],

            ['key' => 'nav_ticket', 'language_code' => 'en', 'value' => 'Ticket'],
            ['key' => 'nav_ticket', 'language_code' => 'bn', 'value' => 'টিকেট'],

            ['key' => 'nav_faq', 'language_code' => 'en', 'value' => 'FAQ'],
            ['key' => 'nav_faq', 'language_code' => 'bn', 'value' => 'প্রশ্নোত্তর'],

            ['key' => 'nav_pages', 'language_code' => 'en', 'value' => 'Pages'],
            ['key' => 'nav_pages', 'language_code' => 'bn', 'value' => 'পেজসমূহ'],

            ['key' => 'nav_contact', 'language_code' => 'en', 'value' => 'Contact'],
            ['key' => 'nav_contact', 'language_code' => 'bn', 'value' => 'যোগাযোগ'],

            ['key' => 'nav_login', 'language_code' => 'en', 'value' => 'Login'],
            ['key' => 'nav_login', 'language_code' => 'bn', 'value' => 'লগইন'],

            ['key' => 'nav_dashboard', 'language_code' => 'en', 'value' => 'Dashboard'],
            ['key' => 'nav_dashboard', 'language_code' => 'bn', 'value' => 'ড্যাশবোর্ড'],

            ['key' => 'nav_languages', 'language_code' => 'en', 'value' => 'Languages'],
            ['key' => 'nav_languages', 'language_code' => 'bn', 'value' => 'ভাষা'],

            ['key' => 'nav_user_dashboard', 'language_code' => 'en', 'value' => 'User Dashboard'],
            ['key' => 'nav_user_dashboard', 'language_code' => 'bn', 'value' => 'ব্যবহারকারী ড্যাশবোর্ড'],

            ['key' => 'nav_ticket_details', 'language_code' => 'en', 'value' => 'Ticket Details'],
            ['key' => 'nav_ticket_details', 'language_code' => 'bn', 'value' => 'টিকেট বিস্তারিত'],

            ['key' => 'nav_privacy_policy', 'language_code' => 'en', 'value' => 'Privacy Policy'],
            ['key' => 'nav_privacy_policy', 'language_code' => 'bn', 'value' => 'গোপনীয়তা নীতি'],

            ['key' => 'nav_terms_conditions', 'language_code' => 'en', 'value' => 'Terms & Conditions'],
            ['key' => 'nav_terms_conditions', 'language_code' => 'bn', 'value' => 'শর্তাবলী'],
        ];

        foreach ($texts as $text) {
            Text::updateOrCreate(
                [
                    'key' => $text['key'],
                    'language_code' => $text['language_code']
                ],
                ['value' => $text['value']]
            );
        }
    }
}
