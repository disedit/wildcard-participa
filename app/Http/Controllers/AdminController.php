<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Edition;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('auth');

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        $editionIsOpen = Edition::current()->isOpen();
        return view('admin.dashboard', compact('user', 'token', 'editionIsOpen'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function anullBallot(Request $request)
    {
        $this->middleware('auth.api');
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request, [
            'ID' => 'required',
            'reason' => 'required',
        ]);

        return response()->json($user);
    }
}
