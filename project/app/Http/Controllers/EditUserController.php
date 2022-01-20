<?php

namespace App\Http\Controllers;

use App\Models\Invites;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use \Illuminate\Validation\ValidationException;




class EditUserController extends Controller{

    public function index(){

        $invites = DB::table('invites')->where('user_id',Auth::user()->id)->get();

        return view('edit-user', ['invites' => $invites,'user' => Auth::user()]);

    }

    public function ChangeUsername()
    {
        $user = Auth::user();

        try {
        request()->validate([
            'name' => 'required|unique:users',
        ]);
        }
        catch(ValidationException $e){
            return redirect('/edit-user')->with(['show' => 'true'])->withErrors($e->errors());
        }

        $user->name = request()->name;

        $user->save();

        return redirect('/edit-user')->with('success',"Username changed successfully!" );
    }

    public function ChangePassword(){

        $user = Auth::user();

        $userPassword = $user->password;
        try {
        request()->validate([
            'current_password' => 'required',
            'new_password' => 'required|same:repeated_new_password|min:8',
            'repeated_new_password' => 'required',
        ]);
        }
        catch(ValidationException $e){
            return redirect('/edit-user')->with(['show' => 'true'])->withErrors($e->errors());
        }

        if(!Hash::check(request()->current_password,$userPassword)){
            return redirect('/edit-user')->with(['show' => 'true'])->withErrors(['current_password'=>'Wrong current password.']);
        }

        $user->password = Hash::make(request()->new_password);

        $user->save();

        return redirect('/edit-user')->with('success',"Password changed successfully!" );
    }

    public function ChangeAvatar(){

        $user = Auth::user();

        try {
            request()->validate([
                'image' => 'required|image|mimes:jpg,png|max:2048',
            ]);
        }
        catch(ValidationException $e){
            return redirect('/edit-user')->with(['show' => 'true'])->withErrors($e->errors());
        }

        $fileExtension = request()->file('image')->getClientOriginalExtension();
        $fileName = pathinfo(request()->file('image')->getClientOriginalName(),PATHINFO_FILENAME);
        $fileNameToStore = $fileName.'_'.time().'.'.$fileExtension;
        request()->image->move(storage_path('app/public/user_avatars/'),$fileNameToStore);
        $imagePath = 'storage/user_avatars/'.$fileNameToStore;

        $user->avatar = $imagePath;

        $user->save();

        return redirect('/edit-user')->with('success',"Avatar changed successfully!" );
    }

    public function ChangeEmail(){

        $user = Auth::user();

        try {
            request()->validate([
                'email' => 'required|string|email|max:255|unique:users|same:repeated_new_email',
                'repeated_new_email' => 'required',
            ]);
        }
        catch(ValidationException $e){
            return redirect('/edit-user')->with(['show' => 'true'])->withErrors($e->errors());
        }

        $user->email = request()->email;

        $user->save();

        return redirect('/edit-user')->with('success',"Email changed successfully!" );
    }





}
