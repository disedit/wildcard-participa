<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Edition;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BallotController extends Controller
{
    /**
     * JSON object with edition information, including ballot questions
     *
     * @return \Illuminate\Http\Response
     */
    public function ballots(Ballot $ballot)
    {
        return view('ballot', compact('ballot'));
    }

    /**
     * JSON object with edition information, including ballot questions
     *
     * @return \Illuminate\Http\Response
     */
    public function ballotJSON()
    {
        $edition = new Edition;
        $edition = $edition->current('ballot');
        return response()->json($edition);
    }

    /**
     * JSON object with edition information, including ballot questions
     *
     * @return \Illuminate\Http\Response
     */
    public function ballotQR($ref)
    {
        \Debugbar::disable();

        $qr = QrCode::size(200)->generate($ref);

        return response($qr)->header('Content-Type', 'image/svg+xml');
    }
}
