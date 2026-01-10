<?php

namespace Database\Seeders;

use App\Models\Text;
use Illuminate\Database\Seeder;

class TextSeeder extends Seeder
{
    public function run(): void
    {
        $texts = [
            // ==================== Navigation ====================
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

            ['key' => 'nav_privacy_policy', 'language_code' => 'en', 'value' => 'Privacy Policy'],
            ['key' => 'nav_privacy_policy', 'language_code' => 'bn', 'value' => 'গোপনীয়তা নীতি'],

            ['key' => 'nav_terms_conditions', 'language_code' => 'en', 'value' => 'Terms & Conditions'],
            ['key' => 'nav_terms_conditions', 'language_code' => 'bn', 'value' => 'শর্তাবলী'],

            ['key' => 'trmsandcondation', 'language_code' => 'en', 'value' => 'Terms & Conditions'],
            ['key' => 'trmsandcondation', 'language_code' => 'bn', 'value' => 'শর্তাবলী'],

            // ==================== Dashboard Section ====================
            ['key' => 'User Dashboard', 'language_code' => 'en', 'value' => 'User Dashboard'],
            ['key' => 'User Dashboard', 'language_code' => 'bn', 'value' => 'ব্যবহারকারী ড্যাশবোর্ড'],

            ['key' => 'Welcome', 'language_code' => 'en', 'value' => 'Welcome'],
            ['key' => 'Welcome', 'language_code' => 'bn', 'value' => 'স্বাগতম'],

            ['key' => 'Referral URL', 'language_code' => 'en', 'value' => 'Referral URL'],
            ['key' => 'Referral URL', 'language_code' => 'bn', 'value' => 'রেফারেল লিংক'],

            ['key' => 'Copy', 'language_code' => 'en', 'value' => 'Copy'],
            ['key' => 'Copy', 'language_code' => 'bn', 'value' => 'কপি করুন'],

            ['key' => 'Dashboard', 'language_code' => 'en', 'value' => 'Dashboard'],
            ['key' => 'Dashboard', 'language_code' => 'bn', 'value' => 'ড্যাশবোর্ড'],

            ['key' => 'Deposit Now', 'language_code' => 'en', 'value' => 'Deposit Now'],
            ['key' => 'Deposit Now', 'language_code' => 'bn', 'value' => 'এখনই জমা দিন'],

            ['key' => 'Withdraw', 'language_code' => 'en', 'value' => 'Withdraw'],
            ['key' => 'Withdraw', 'language_code' => 'bn', 'value' => 'উত্তোলন'],

            ['key' => 'Ticket History', 'language_code' => 'en', 'value' => 'Ticket History'],
            ['key' => 'Ticket History', 'language_code' => 'bn', 'value' => 'টিকেট ইতিহাস'],

            ['key' => 'Profile Settings', 'language_code' => 'en', 'value' => 'Profile Settings'],
            ['key' => 'Profile Settings', 'language_code' => 'bn', 'value' => 'প্রোফাইল সেটিংস'],

            ['key' => 'Winner List', 'language_code' => 'en', 'value' => 'Winner List'],
            ['key' => 'Winner List', 'language_code' => 'bn', 'value' => 'বিজয়ীদের তালিকা'],

            ['key' => 'Password Change', 'language_code' => 'en', 'value' => 'Password Change'],
            ['key' => 'Password Change', 'language_code' => 'bn', 'value' => 'পাসওয়ার্ড পরিবর্তন'],

            ['key' => 'KYC Verification', 'language_code' => 'en', 'value' => 'KYC Verification'],
            ['key' => 'KYC Verification', 'language_code' => 'bn', 'value' => 'কেওয়াইসি যাচাইকরণ'],

            ['key' => 'Support Contact', 'language_code' => 'en', 'value' => 'Support Contact'],
            ['key' => 'Support Contact', 'language_code' => 'bn', 'value' => 'সহায়তা যোগাযোগ'],

            ['key' => 'Sign Out', 'language_code' => 'en', 'value' => 'Sign Out'],
            ['key' => 'Sign Out', 'language_code' => 'bn', 'value' => 'প্রস্থান'],

            ['key' => 'Back to Admin', 'language_code' => 'en', 'value' => 'Back to Admin'],
            ['key' => 'Back to Admin', 'language_code' => 'bn', 'value' => 'অ্যাডমিনে ফিরে যান'],

            // ==================== Dashboard Cards ====================
            ['key' => 'Total Deposit', 'language_code' => 'en', 'value' => 'Total Deposit'],
            ['key' => 'Total Deposit', 'language_code' => 'bn', 'value' => 'মোট জমা'],

            ['key' => 'Total Balance', 'language_code' => 'en', 'value' => 'Total Balance'],
            ['key' => 'Total Balance', 'language_code' => 'bn', 'value' => 'মোট ব্যালেন্স'],

            ['key' => 'Total Withdraw', 'language_code' => 'en', 'value' => 'Total Withdraw'],
            ['key' => 'Total Withdraw', 'language_code' => 'bn', 'value' => 'মোট উত্তোলন'],

            ['key' => 'টাকা', 'language_code' => 'en', 'value' => 'BDT'],
            ['key' => 'টাকা', 'language_code' => 'bn', 'value' => 'টাকা'],

            // ==================== Lottery Package ====================
            ['key' => 'Draw Date', 'language_code' => 'en', 'value' => 'Draw Date'],
            ['key' => 'Draw Date', 'language_code' => 'bn', 'value' => 'ড্র তারিখ'],

            ['key' => '1st Prize', 'language_code' => 'en', 'value' => '1st Prize'],
            ['key' => '1st Prize', 'language_code' => 'bn', 'value' => '১ম পুরস্কার'],

            ['key' => '2nd Prize', 'language_code' => 'en', 'value' => '2nd Prize'],
            ['key' => '2nd Prize', 'language_code' => 'bn', 'value' => '২য় পুরস্কার'],

            ['key' => '3rd Prize', 'language_code' => 'en', 'value' => '3rd Prize'],
            ['key' => '3rd Prize', 'language_code' => 'bn', 'value' => '৩য় পুরস্কার'],

            ['key' => 'Total Participants', 'language_code' => 'en', 'value' => 'Total Participants'],
            ['key' => 'Total Participants', 'language_code' => 'bn', 'value' => 'মোট অংশগ্রহণকারী'],

            ['key' => 'Best Gift', 'language_code' => 'en', 'value' => 'Best Gift'],
            ['key' => 'Best Gift', 'language_code' => 'bn', 'value' => 'সেরা উপহার'],

            ['key' => 'Buy Ticket', 'language_code' => 'en', 'value' => 'Buy Ticket'],
            ['key' => 'Buy Ticket', 'language_code' => 'bn', 'value' => 'টিকিট কিনুন'],

            ['key' => 'Login to Play', 'language_code' => 'en', 'value' => 'Login to Play'],
            ['key' => 'Login to Play', 'language_code' => 'bn', 'value' => 'খেলতে লগইন করুন'],

            ['key' => 'No lottery packages available', 'language_code' => 'en', 'value' => 'No lottery packages available'],
            ['key' => 'No lottery packages available', 'language_code' => 'bn', 'value' => 'কোনো লটারি প্যাকেজ উপলব্ধ নেই'],

            // ==================== Video Section ====================
            ['key' => 'LIVE NOW', 'language_code' => 'en', 'value' => 'LIVE NOW'],
            ['key' => 'LIVE NOW', 'language_code' => 'bn', 'value' => 'এখন লাইভ'],

            ['key' => 'Live Draw Coming Soon', 'language_code' => 'en', 'value' => 'Live Draw Coming Soon!'],
            ['key' => 'Live Draw Coming Soon', 'language_code' => 'bn', 'value' => 'লাইভ ড্র শীঘ্রই আসছে!'],

            ['key' => 'Video Start', 'language_code' => 'en', 'value' => 'Video Start'],
            ['key' => 'Video Start', 'language_code' => 'bn', 'value' => 'ভিডিও শুরু'],

            ['key' => 'Calculating', 'language_code' => 'en', 'value' => 'Calculating...'],
            ['key' => 'Calculating', 'language_code' => 'bn', 'value' => 'গণনা করা হচ্ছে...'],

            ['key' => 'Not Set', 'language_code' => 'en', 'value' => 'Not Set'],
            ['key' => 'Not Set', 'language_code' => 'bn', 'value' => 'সেট করা হয়নি'],

            // ==================== Transaction History ====================
            ['key' => 'Transaction History', 'language_code' => 'en', 'value' => 'Transaction History'],
            ['key' => 'Transaction History', 'language_code' => 'bn', 'value' => 'লেনদেন ইতিহাস'],

            ['key' => 'Transaction ID', 'language_code' => 'en', 'value' => 'Transaction ID'],
            ['key' => 'Transaction ID', 'language_code' => 'bn', 'value' => 'লেনদেন আইডি'],

            ['key' => 'Type', 'language_code' => 'en', 'value' => 'Type'],
            ['key' => 'Type', 'language_code' => 'bn', 'value' => 'ধরন'],

            ['key' => 'Date', 'language_code' => 'en', 'value' => 'Date'],
            ['key' => 'Date', 'language_code' => 'bn', 'value' => 'তারিখ'],

            ['key' => 'Amount', 'language_code' => 'en', 'value' => 'Amount'],
            ['key' => 'Amount', 'language_code' => 'bn', 'value' => 'পরিমাণ'],

            ['key' => 'Status', 'language_code' => 'en', 'value' => 'Status'],
            ['key' => 'Status', 'language_code' => 'bn', 'value' => 'স্থিতি'],

            ['key' => 'Deposit', 'language_code' => 'en', 'value' => 'Deposit'],
            ['key' => 'Deposit', 'language_code' => 'bn', 'value' => 'জমা'],

            ['key' => 'Approved', 'language_code' => 'en', 'value' => 'Approved'],
            ['key' => 'Approved', 'language_code' => 'bn', 'value' => 'অনুমোদিত'],

            ['key' => 'Rejected', 'language_code' => 'en', 'value' => 'Rejected'],
            ['key' => 'Rejected', 'language_code' => 'bn', 'value' => 'প্রত্যাখ্যাত'],

            ['key' => 'No transaction history found', 'language_code' => 'en', 'value' => 'No transaction history found.'],
            ['key' => 'No transaction history found', 'language_code' => 'bn', 'value' => 'কোনো লেনদেন ইতিহাস পাওয়া যায়নি।'],

            // ==================== Banner / Hero Section ====================
            ['key' => 'Win Big With LuckySpotBD', 'language_code' => 'en', 'value' => 'Win Big With LuckySpotBD'],
            ['key' => 'Win Big With LuckySpotBD', 'language_code' => 'bn', 'value' => 'LuckySpotBD এর সাথে বড় পুরস্কার জিতুন'],

            ['key' => 'Buy tickets and get a chance to win amazing prizes', 'language_code' => 'en', 'value' => 'Buy tickets and get a chance to win amazing prizes'],
            ['key' => 'Buy tickets and get a chance to win amazing prizes', 'language_code' => 'bn', 'value' => 'টিকিট কিনুন এবং আশ্চর্যজনক পুরস্কার জেতার সুযোগ পান'],

            ['key' => 'ticket_now', 'language_code' => 'en', 'value' => 'Ticket Now'],
            ['key' => 'ticket_now', 'language_code' => 'bn', 'value' => 'এখনই টিকিট'],

            ['key' => 'sign_up', 'language_code' => 'en', 'value' => 'Sign Up'],
            ['key' => 'sign_up', 'language_code' => 'bn', 'value' => 'নিবন্ধন করুন'],

            ['key' => 'register', 'language_code' => 'en', 'value' => 'Register'],
            ['key' => 'register', 'language_code' => 'bn', 'value' => 'নিবন্ধন'],

            ['key' => 'logout', 'language_code' => 'en', 'value' => 'Logout'],
            ['key' => 'logout', 'language_code' => 'bn', 'value' => 'প্রস্থান'],

            // ==================== Common Buttons ====================
            ['key' => 'submit', 'language_code' => 'en', 'value' => 'Submit'],
            ['key' => 'submit', 'language_code' => 'bn', 'value' => 'জমা দিন'],

            ['key' => 'cancel', 'language_code' => 'en', 'value' => 'Cancel'],
            ['key' => 'cancel', 'language_code' => 'bn', 'value' => 'বাতিল'],

            ['key' => 'save', 'language_code' => 'en', 'value' => 'Save'],
            ['key' => 'save', 'language_code' => 'bn', 'value' => 'সংরক্ষণ'],

            ['key' => 'edit', 'language_code' => 'en', 'value' => 'Edit'],
            ['key' => 'edit', 'language_code' => 'bn', 'value' => 'সম্পাদনা'],

            ['key' => 'delete', 'language_code' => 'en', 'value' => 'Delete'],
            ['key' => 'delete', 'language_code' => 'bn', 'value' => 'মুছুন'],

            ['key' => 'view', 'language_code' => 'en', 'value' => 'View'],
            ['key' => 'view', 'language_code' => 'bn', 'value' => 'দেখুন'],

            ['key' => 'buy_now', 'language_code' => 'en', 'value' => 'Buy Now'],
            ['key' => 'buy_now', 'language_code' => 'bn', 'value' => 'এখনই কিনুন'],

            ['key' => 'view_details', 'language_code' => 'en', 'value' => 'View Details'],
            ['key' => 'view_details', 'language_code' => 'bn', 'value' => 'বিস্তারিত দেখুন'],

            // ==================== Forms ====================
            ['key' => 'email', 'language_code' => 'en', 'value' => 'Email'],
            ['key' => 'email', 'language_code' => 'bn', 'value' => 'ইমেইল'],

            ['key' => 'password', 'language_code' => 'en', 'value' => 'Password'],
            ['key' => 'password', 'language_code' => 'bn', 'value' => 'পাসওয়ার্ড'],

            ['key' => 'confirm_password', 'language_code' => 'en', 'value' => 'Confirm Password'],
            ['key' => 'confirm_password', 'language_code' => 'bn', 'value' => 'পাসওয়ার্ড নিশ্চিত করুন'],

            ['key' => 'name', 'language_code' => 'en', 'value' => 'Name'],
            ['key' => 'name', 'language_code' => 'bn', 'value' => 'নাম'],

            ['key' => 'phone', 'language_code' => 'en', 'value' => 'Phone'],
            ['key' => 'phone', 'language_code' => 'bn', 'value' => 'ফোন'],

            ['key' => 'address', 'language_code' => 'en', 'value' => 'Address'],
            ['key' => 'address', 'language_code' => 'bn', 'value' => 'ঠিকানা'],

            ['key' => 'message', 'language_code' => 'en', 'value' => 'Message'],
            ['key' => 'message', 'language_code' => 'bn', 'value' => 'বার্তা'],

            // ==================== Tickets ====================
            ['key' => 'available_tickets', 'language_code' => 'en', 'value' => 'Available Tickets'],
            ['key' => 'available_tickets', 'language_code' => 'bn', 'value' => 'উপলব্ধ টিকেট'],

            ['key' => 'my_tickets', 'language_code' => 'en', 'value' => 'My Tickets'],
            ['key' => 'my_tickets', 'language_code' => 'bn', 'value' => 'আমার টিকেট'],

            ['key' => 'ticket_price', 'language_code' => 'en', 'value' => 'Ticket Price'],
            ['key' => 'ticket_price', 'language_code' => 'bn', 'value' => 'টিকেটের মূল্য'],

            ['key' => 'ticket_number', 'language_code' => 'en', 'value' => 'Ticket Number'],
            ['key' => 'ticket_number', 'language_code' => 'bn', 'value' => 'টিকেট নম্বর'],

            ['key' => 'draw_date', 'language_code' => 'en', 'value' => 'Draw Date'],
            ['key' => 'draw_date', 'language_code' => 'bn', 'value' => 'ড্র তারিখ'],

            ['key' => 'prize', 'language_code' => 'en', 'value' => 'Prize'],
            ['key' => 'prize', 'language_code' => 'bn', 'value' => 'পুরস্কার'],

            // ==================== Status ====================
            ['key' => 'active', 'language_code' => 'en', 'value' => 'Active'],
            ['key' => 'active', 'language_code' => 'bn', 'value' => 'সক্রিয়'],

            ['key' => 'inactive', 'language_code' => 'en', 'value' => 'Inactive'],
            ['key' => 'inactive', 'language_code' => 'bn', 'value' => 'নিষ্ক্রিয়'],

            ['key' => 'pending', 'language_code' => 'en', 'value' => 'Pending'],
            ['key' => 'pending', 'language_code' => 'bn', 'value' => 'মুলতুবি'],

            ['key' => 'completed', 'language_code' => 'en', 'value' => 'Completed'],
            ['key' => 'completed', 'language_code' => 'bn', 'value' => 'সম্পন্ন'],

            // ==================== Messages ====================
            ['key' => 'success_message', 'language_code' => 'en', 'value' => 'Operation completed successfully'],
            ['key' => 'success_message', 'language_code' => 'bn', 'value' => 'সফলভাবে সম্পন্ন হয়েছে'],

            ['key' => 'error_message', 'language_code' => 'en', 'value' => 'Something went wrong'],
            ['key' => 'error_message', 'language_code' => 'bn', 'value' => 'কিছু ভুল হয়েছে'],

            ['key' => 'no_data_found', 'language_code' => 'en', 'value' => 'No data found'],
            ['key' => 'no_data_found', 'language_code' => 'bn', 'value' => 'কোনো তথ্য পাওয়া যায়নি'],

            ['key' => 'loading', 'language_code' => 'en', 'value' => 'Loading...'],
            ['key' => 'loading', 'language_code' => 'bn', 'value' => 'লোড হচ্ছে...'],

            // ==================== Language Change Messages ====================
            ['key' => 'language_changed', 'language_code' => 'en', 'value' => 'Language changed successfully!'],
            ['key' => 'language_changed', 'language_code' => 'bn', 'value' => 'ভাষা সফলভাবে পরিবর্তন হয়েছে!'],

            ['key' => 'changing_to_english', 'language_code' => 'en', 'value' => 'Changing to English...'],
            ['key' => 'changing_to_english', 'language_code' => 'bn', 'value' => 'ইংরেজিতে পরিবর্তন হচ্ছে...'],

            ['key' => 'changing_to_bengali', 'language_code' => 'en', 'value' => 'Changing to Bengali...'],
            ['key' => 'changing_to_bengali', 'language_code' => 'bn', 'value' => 'বাংলায় পরিবর্তন হচ্ছে...'],

            ['key' => 'already_in_english', 'language_code' => 'en', 'value' => 'Already in English'],
            ['key' => 'already_in_english', 'language_code' => 'bn', 'value' => 'ইতিমধ্যে ইংরেজিতে আছে'],

            ['key' => 'already_in_bengali', 'language_code' => 'en', 'value' => 'Already in Bengali'],
            ['key' => 'already_in_bengali', 'language_code' => 'bn', 'value' => 'ইতিমধ্যে বাংলায় আছে'],

            // ==================== Additional Common Text ====================
            ['key' => 'N/A', 'language_code' => 'en', 'value' => 'N/A'],
            ['key' => 'N/A', 'language_code' => 'bn', 'value' => 'প্রযোজ্য নয়'],

            ['key' => 'User', 'language_code' => 'en', 'value' => 'User'],
            ['key' => 'User', 'language_code' => 'bn', 'value' => 'ব্যবহারকারী'],

            ['key' => 'Referral code not available', 'language_code' => 'en', 'value' => 'Referral code not available'],
            ['key' => 'Referral code not available', 'language_code' => 'bn', 'value' => 'রেফারেল কোড উপলব্ধ নেই'],

            ['key' => 'Referral link copied to clipboard', 'language_code' => 'en', 'value' => 'Referral link copied to clipboard!'],
            ['key' => 'Referral link copied to clipboard', 'language_code' => 'bn', 'value' => 'রেফারেল লিংক কপি হয়েছে!'],
        ];

        $this->command->info('🔄 Starting translations seeding...');
        $this->command->newLine();

        $created = 0;
        $updated = 0;
        $errors = 0;

        foreach ($texts as $text) {
            try {
                $result = Text::updateOrCreate(
                    [
                        'key' => $text['key'],
                        'language_code' => $text['language_code']
                    ],
                    ['value' => $text['value']]
                );

                if ($result->wasRecentlyCreated) {
                    $created++;
                } else {
                    $updated++;
                }
            } catch (\Exception $e) {
                $errors++;
                $this->command->error("❌ Failed to create/update: {$text['key']} ({$text['language_code']})");
                $this->command->error("   Error: " . $e->getMessage());
            }
        }

        $this->command->newLine();
        $this->command->info('✅ Translations seeded successfully!');
        $this->command->info("📊 Statistics:");
        $this->command->info("   ✨ Created: {$created}");
        $this->command->info("   🔄 Updated: {$updated}");

        if ($errors > 0) {
            $this->command->error("   ❌ Errors: {$errors}");
        }

        $this->command->info("   📝 Total: " . ($created + $updated));
        $this->command->newLine();
    }
}
