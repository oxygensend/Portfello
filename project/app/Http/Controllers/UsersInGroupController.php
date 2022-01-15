<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UsersInGroupController extends Controller {


    public function update(Group $group)
    {

       try{
           $attributes = request()->validate([

            'username' => ['required', Rule::exists('users', 'name')],
        ]);
}catch( ValidationException $e)
{
    return redirect(route('groups.show', $group))->with(['show'=>'true'])->withErrors($e->errors());
}
        $user = DB::table('users')->where('name', request('username'))->first();
        $show = 'true';
        if ($group->users->contains($user->id)) {
           $session='fail';
           $msg= 'User ' . $user->name . ' is already in group';
        } else {
            $session = 'success';
            $show = 'false';
            $msg =  'Request has been sent to ' . $user->name;
            $group->users()->attach($user->id);
        }
        return redirect(route('groups.show', $group))->with($session ,$msg);

    }

    public function destroy(Group $group, User $user){



    }
}
