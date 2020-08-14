<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    /**
     * Show calendar.
     *
     * @return View
     */
    public function show()
    {
        return view('Admin\Calendar\show');
    }
}

