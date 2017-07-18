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

    /**
     * The active edition.
     *
     * @var object
     */
    protected $edition;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->edition = Edition::current();
    }

    /**
     * Determine what page to show on the frontpage.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $now = time();
        $edition = $this->edition;

        // If within voting window dates, show voting booth
        if($edition->isOpen()){
            $user = $request->user();
            $inPerson = ($user) ? true : false;
            $token = ($inPerson) ? JWTAuth::fromUser($user) : null;
            return view('booth', compact('edition', 'token', 'inPerson'));
        }

        // If in limbo (after end_date and before publish_results), show placeholder
        if($edition->isAwaitingResults()){
            return view('placeholder', compact('edition'));
        }

        // If after end_date AND publish_results, show results
        if($edition->resultsPublished()){
            $results = $edition->results();
            return view('results', compact('edition', 'results'));
        }

        // If none of the previous conditions are met
        // display the About page as a placeholder before the vote.
        $this->about();

    }

    /**
     * Placeholder page with instructions.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        $now = time();
        $edition = $this->edition;

        return view('about', compact('edition'));
    }

    /**
     * Show a user's IP address to assist Support
     * in troubleshooting problems with IP limits.
     *
     * @return \Illuminate\View\View
     */
    public function myIpAddress(Request $request)
    {
        $ip = $request->ip();

        return view('ip_address', compact('ip'));
    }
}
