<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Edition;
use App\Ballot;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BallotController extends Controller
{
    /**
     * Page to look up a ballot on the system
     *
     * @return \Illuminate\View\View
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
        $edition = Edition::current('ballot');
        return response()->json($edition);
    }

    /**
     * QR image that links to a stored ballot on the system
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
