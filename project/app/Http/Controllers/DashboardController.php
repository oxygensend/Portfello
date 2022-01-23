<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function __invoke(Request $request)
    {


        $groups=\Auth::user()->active_groups();

       $belong_to_group = auth()->user()->groups()->count() ? true : false;
        return view('dashboard', ['belong_to_group' => $belong_to_group])->withGroups( $groups);
    }


}
