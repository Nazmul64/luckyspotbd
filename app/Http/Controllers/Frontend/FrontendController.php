<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
   public function frontend()
{



    $slider_show = Slider::where('status', 'active')->get();

    $lottery_show = Lottery::where('status', 'active')
        ->orderBy('draw_date', 'asc')
        ->get();

    return view('frontend.index', compact('slider_show', 'lottery_show'));
}

    public function contactpages()
    {
        $cotact_setting=Setting::first();
         return view('frontend.contact.index', compact('cotact_setting'));
    }


}
