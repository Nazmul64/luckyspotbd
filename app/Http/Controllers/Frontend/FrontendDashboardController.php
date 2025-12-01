<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendDashboardController extends Controller
{
    public function frontend()
    {
        return view('frontend.dashboard.index');
    }
}
