<?php

namespace App\Services;

use App\Http\Requests\ChangeAvatarRequest;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EditUserService {

    function getImage(ChangeAvatarRequest $request): string
    {
        $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->image->move(storage_path('app/public/user_avatars/'), $fileName);
        $imagePath = '/storage/user_avatars/' . $fileName;
        File::delete(Auth::user()->avatar);
        return $imagePath;
    }

    function deleteAccount()
    {
        foreach (\auth()->user()->groups as $group) {
            if ($group->admin->id == auth()->user()->id) {
                $new_admin = $this->setNewAdmin($group);
                if ($new_admin == null)
                    Group::find($group->id)->delete();
                else
                    Group::find($group->id)->update(['user_id' => $new_admin->user_id]);

            }

        }
    }
    function setNewAdmin(Group $group){
       return DB::table('group_user')->where('group_id', $group->id)
           ->where('user_id', '!=', auth()->user()->id)
           ->orderBy('created_at')->first();
    }
}
