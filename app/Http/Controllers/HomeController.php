<?php

namespace App\Http\Controllers;

use App\Models\Reservations\Reservation;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }
    public function frontend()
    {
        return view('frontend.layout.header');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['users'] = User::get();
        $data['reservation'] = Reservation::where('type', 'Reservation')->get();
        $data['purchase'] = Reservation::where('type', 'Purchase')->get();
        $data['business'] = User::where('role_id', 3)->get();
        $data['affiliate'] = User::where('role_id', 4)->get();
        return view('dashboard.index', compact('data'));
    }
}
