<?php

namespace App\Http\Controllers;

use App\Actions\SetSessionMessage;
use App\Events\InvitesStatus;
use App\Http\Requests\UserExistRequest;
use App\Models\Group;
use App\Models\Invites;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UsersInGroupController extends Controller {


    public function store(Group $group, UserExistRequest $request, SetSessionMessage $setSessionMessage)
    {
        try {
            $user = DB::table('users')->where('name', $request->get('username'))->first();

        } catch (ValidationException $e) {
            return redirect(route('groups.edit', $group))->with(['show' => 'true'])->withErrors($e->errors());
        }

        $msg = '';
        $session = '';
        $setSessionMessage->execute($msg, $session, $group, $user);

        event(new InvitesStatus($user));
        return redirect(route('groups.edit', $group))->with($session, $msg);

    }

    public function update(Group $group, $user_id)
    {
        Group::find($group->id)->update(['user_id' => $user_id]);
        return redirect(route('groups.edit', $group))->with('success', 'Admin has been changed');
    }

    public function destroy(Group $group, $user_id)
    {
        DB::table('group_user')->where('group_user.group_id', '=', $group->id)->where('group_user.user_id', '=', $user_id)->delete();
        return redirect(route('groups.edit', $group))->with('success', 'User has been deleted');
    }


}
