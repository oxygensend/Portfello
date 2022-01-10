<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => 'image|mimes:jpg,png|svg|max:2048'
        ]);

        //avatar handling
        if (!empty($request->image)){
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME);
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExtension;
            $request->image->move(public_path('images'),$fileNameToStore);
            $imagePath = '/images/'.$fileNameToStore;
        }else{
            $imagePath = '/images/default_avatar.png';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $imagePath
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
