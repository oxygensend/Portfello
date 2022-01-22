<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
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

        ddd(auth()->user()->getBalanceWithUser(User::find(1), Group::find(1)));
        $groups=\Auth::user()->active_groups();

        return view('dashboard')->withGroups( $groups);
    }


}
