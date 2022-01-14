<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UsersInGroupController extends Controller {


    public function update(Group $group)
    {
        $attributes = request()->validate([
            'username' => ['required', Rule::exists('users', 'name')],
        ]);
        $user = DB::table('users')->where('name', request('username'))->first();
        $show = 'true';
        if ($group->users->contains($user->id)) {
            //throw ValidationException::withMessages(['username' => 'This user is already in group.']);
           $session='fail';
           $msg= 'User ' . $user->name . ' is already in group';
        } else {
            $session = 'success';
            $show = 'false';
            $msg =  'Request has been sent to ' . $user->name;
            $group->users()->attach($user->id);
        }
        return redirect(route('groups.show', $group))->with([$session =>$msg, 'show' => $show]);

    }

    public function destroy(Group $group, User $user){



    }
}
