<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeAvatarRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeUsernameRequest;
use App\Models\Group;
use App\Models\Invites;
use App\Models\User;
use App\Services\EditUserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use \Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;


class EditUserController extends Controller {

    public function index()
    {

        $invites = DB::table('invites')->where('user_id', Auth::user()->id)->get();
        DB::table('invites')->where('user_id', auth()->user()->id)
            ->where('displayed', false)->update(['displayed' => true]);

        return view('edit-user', ['invites' => $invites, 'user' => Auth::user()]);

    }

    public function ChangeUsername(ChangeUsernameRequest $request)
    {
        try {
            Auth::user()->update(['name' => $request->name]);
        } catch (ValidationException $e) {
            return redirect('/edit-user')->with(['show' => 'true'])->withErrors($e->errors());
        }

        return redirect('/edit-user')->with('success', "Username changed successfully!");
    }

    public function ChangePassword(ChangePasswordRequest $request)
    {


        $userPassword = Auth::user()->password;
        try {
            if (!Hash::check($request->current_password, $userPassword)) {
                return redirect('/edit-user')->with(['show' => 'true'])->withErrors(['current_password' => 'Wrong current password.']);
            }

            Auth::user()->update(['password' => Hash::make($request->new_password)]);

        } catch (ValidationException $e) {
            return redirect('/edit-user')->with(['show' => 'true'])->withErrors($e->errors());
        }


        return redirect('/edit-user')->with('success', "Password changed successfully!");
    }

    public function ChangeAvatar(ChangeAvatarRequest $request, EditUserService $service)
    {

        try {

            Auth::user()->update(['avatar' => $service->getImage($request)]);

        } catch (\Exception $e) {
            return redirect('/edit-user')->with(['show' => 'true'])->withErrors($e->errors());
        }


        return redirect('/edit-user')->with('success', "Avatar changed successfully!");
    }

    public function ChangeEmail(ChangeEmailRequest $request)
    {

        try {

            Auth::user()->update(['email' => $request->email]);

        } catch (ValidationException $e) {
            return redirect('/edit-user')->with(['show' => 'true'])->withErrors($e->errors());
        }


        return redirect('/edit-user')->with('success', "Email changed successfully!");
    }


    public function deleteAccount(EditUserService $service)
    {

       $service->deleteAccount();

        DB::table('users')->where('id', \auth()->user()->id)->delete();
        return redirect('/');
    }


}
