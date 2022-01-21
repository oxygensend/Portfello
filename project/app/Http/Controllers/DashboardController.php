<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $groups=\Auth::user()->groups;
        return view('dashboard')->withGroups($groups);
    }

    public function index()
    {
        $groups=\Auth::user()->groups;
        return view('dashboard')->withGroups($groups);
    }

}
