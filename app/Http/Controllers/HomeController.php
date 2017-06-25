<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Edition;

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
        $this->edition = $edition->current();
    }

    /**
     * Show the homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $now = time();
        $edition = $this->edition;

        // If within voting window dates, show voting booth
        if(strtotime($edition->start_date) <= $now
        && strtotime($edition->end_date) > $now){
            return view('booth.ballot', compact('edition'));
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
}
