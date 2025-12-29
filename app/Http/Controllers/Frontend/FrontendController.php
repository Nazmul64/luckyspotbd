<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Lottery;
use App\Models\Privacypolicy;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Termscondition;
use App\Models\Whychooseusticket;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
   public function frontend()
{



    $slider_show = Slider::where('status', 'active')->get();
    $about = About::where('status', 'active')->get();

    $lottery_show = Lottery::where('status', 'active')
        ->orderBy('draw_date', 'asc')
        ->get();

        $whychooseustickets =Whychooseusticket::all();

    return view('frontend.index', compact('slider_show', 'lottery_show','about', 'whychooseustickets'));
}

    public function contactpages()
    {
        $cotact_setting=Setting::first();
         return view('frontend.contact.index', compact('cotact_setting'));
    }

    public function privacy()
    {
        $privacy=Privacypolicy::first();
         return view('frontend.privacy.index', compact('privacy'));
    }


    public function trmsandcondation()
    {

        $trmsandcondation=Termscondition::first();
         return view('frontend.trmsandcondation.index', compact('trmsandcondation'));
    }


}
