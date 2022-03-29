<?php

namespace App\Actions;

use App\Models\Group;
use App\Models\Invites;
use Illuminate\Support\Facades\DB;

class SetSessionMessage {

    public function execute(&$msg, &$session,Group $group, $user)
    {
        if ($group->users->contains($user->id)) {
            $session = 'fail';
            $msg = 'User ' . $user->name . ' is already in group';

        } else if (DB::table('invites')->where('user_id', $user->id)->where('group_id', $group->id)->count()) {
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
