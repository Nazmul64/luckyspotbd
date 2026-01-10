<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Faq;
use App\Models\Howtoticket;
use App\Models\Lottery;
use App\Models\LotteryResult;
use App\Models\Privacypolicy;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Support;
use App\Models\Termscondition;
use App\Models\Testimonial;
use App\Models\Whychooseusticket;
use Illuminate\Http\Request;
use Termwind\Components\Hr;

class FrontendController extends Controller
{
   public function frontend()
{
    $slider_show = Slider::where('status', 'active')->get();
    $about = About::where('status', 'active')->get();
    $lottery_show = Lottery::where('status', 'active')->orderBy('draw_date')->get();
    $whychooseustickets = Whychooseusticket::all();
    $faq = Faq::all();
    $testmonail = Testimonial::all();
    $howtoticket = Howtoticket::first();
    $today = now()->startOfDay();

    $packageWinners = LotteryResult::with(['user', 'userPackageBuy'])
        ->where('draw_date', '>=', $today)
        ->orderBy('position')
        ->take(3)
        ->get();

    return view('frontend.index', compact(
        'slider_show',
        'lottery_show',
        'about',
        'whychooseustickets',
        'faq',
        'testmonail',
        'packageWinners',
        'howtoticket',
    ));
}


    public function contactpages()
    {
        $cotact_setting=Setting::first();
         return view('frontend.contact.index', compact('cotact_setting'));
    }

 public function privacy()
{
    // প্রথম record নিলাম, না থাকলে null
    $privacy = \App\Models\Privacypolicy::first();

    return view('frontend.privacy.index', compact('privacy'));
}


    public function trmsandcondation()
    {

        $trmsandcondation = Termscondition::first(); // প্রথম record নিলে যথেষ্ট
        return view('frontend.trmsandcondation.index', compact('trmsandcondation'));
    }


    public function supportcontact()
    {
        $supportcontact=Support::all();
         return view('frontend.supportcontact.index', compact('supportcontact'));
    }


}
