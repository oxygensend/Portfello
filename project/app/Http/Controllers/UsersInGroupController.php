<?php

namespace App\Http\Controllers;

use App\Events\InvitesStatus;
use App\Models\Group;
use App\Models\Invites;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UsersInGroupController extends Controller {


    public function store(Group $group)
    {

        try {
            $attributes = request()->validate([

                'username' => ['required', Rule::exists('users', 'name')],
            ]);
        } catch (ValidationException $e) {
            return redirect(route('groups.edit', $group))->with(['show' => 'true'])->withErrors($e->errors());
        }


        $user = DB::table('users')->where('name', request('username'))->first();
        $msg = '';
        $session = '';
        $this->_checkConditions($msg, $session, $group, $user);

        event(new InvitesStatus($user));
        return redirect(route('groups.edit', $group))->with($session, $msg);

    }

    public function destroy(Group $group)
    {
    }

    public function _checkConditions(&$msg, &$session, Group $group, $user)
    {
        if ($group->users->contains($user->id)) {
            $session = 'fail';
            $msg = 'User ' . $user->name . ' is already in group';

        } else if (DB::table('invites')->where('user_id', $user->id)->where('group_id',$group->id)->count()) {
            $session = 'fail';
            $msg = 'Request has been already sent to this user.';
        } else {
            $session = 'success';
            $msg = 'Request has been sent to ' . $user->name;
            Invites::create([
                'user_id' => $user->id,
                'group_id' => $group->id,
                'text' => 'Do you want to join the ' . $group->name . ' group?',
            ]);

        }
    }
}
