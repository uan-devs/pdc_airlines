<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class ReactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function searchFlights()
    {
        return Inertia::render('MyFlight/index');
    }

    public function bookFlight()
    {
        return Inertia::render('Booking/index');
    }

    public function flightResults()
    {
        return Inertia::render('FlySearchResult/index');
    }

    public function memberDashboard()
    {
        return Inertia::render('MemberDashboard/index');
    }

    public function memberFlights()
    {
        return Inertia::render('MemberFlights/index');
    }

    public function page404()
    {
        return Inertia::render('Page404/index');
    }

    public function show()
    {
        Route::view('/{path?}', 'path.to.view')
            ->where('path', '.*')
            ->name('react');
    }
}
