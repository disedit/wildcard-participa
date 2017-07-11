<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Edition;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class HomeController extends Controller
{

    private $edition = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $edition = new Edition;
        $this->edition = $edition->current(false);
    }

    /**
     * Show the homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $now = time();
        $edition = $this->edition;

        // If within voting window dates, show voting booth
        if(strtotime($edition->start_date) <= $now
        && strtotime($edition->end_date) > $now){
            $user = $request->user();
            $inPerson = ($user) ? true : false;
            $token = ($inPerson) ? JWTAuth::fromUser($user) : null;
            return view('booth', compact('edition', 'token', 'inPerson'));
        }

        // If in limbo (after end_date and before publish_results), show placeholder
        if(strtotime($edition->end_date) <= $now
        && strtotime($edition->publish_results) > $now){
            return view('placeholder', compact('edition'));
        }

        // If after end_date AND publish_results, show results
        if(strtotime($edition->end_date) <= $now
        && strtotime($edition->publish_results) <= $now){
            $results = $edition->results();
            return view('results', compact('edition', 'results'));
        }

        return view('home', compact('edition'));

    }

    public function about()
    {
        $now = time();
        $edition = $this->edition;

        return view('home', compact('edition'));
    }

    public function myIpAddress(Request $request)
    {
        $ip = $request->ip();

        return view('ip_address', compact('ip'));
    }
}
