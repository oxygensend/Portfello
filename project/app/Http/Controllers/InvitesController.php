<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Invites;
use Illuminate\Http\Request;

class InvitesController extends Controller
{
    //
    public function accept(Invites $invite)
    {
        $invite->group->users()->attach(auth()->user());
        $invite->delete();


        return redirect('/edit-user')->with('success',"You've joined " . $invite->group->name . " group.");

    }

    public function delete(Invites $invite){

        $invite->delete();
        return redirect('/edit-user');
    }
}
