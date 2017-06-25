<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Edition;

class ArchiveController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $editions = Edition::orderBy('id', 'desc')->all();
        return view('archive.list', compact('editions'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edition(Edition $edition)
    {
        $results = $edition->results();
        return view('archive.edition', compact('edition', 'results'));
    }
}
