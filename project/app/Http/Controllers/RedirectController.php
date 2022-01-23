<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RedirectController
{
    public function __invoke(){
        if(Auth::check()) {
            $groups = Auth::user()->active_groups();
            return redirect('/dashboard')->withGroups($groups);
        }
        else
            return view('home');
    }
}
