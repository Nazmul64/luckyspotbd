<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
   public function frontend()
    {
        $lottery_show=Lottery::all();
        return view('frontend.index',compact('lottery_show'));
    }

}
