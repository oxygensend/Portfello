<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class GroupController extends Controller
{
    public function index()
    {
        return view('groups.index');
    }


    public function create()
    {
        return view('groups.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'user_id' => ['required', Rule::exits('users', 'id')],
            'avatar' => 'requred|image',
        ]);
        $image =  Image::make(request()->file('avatar'));
        $fileName   = 'avatar/' . time() . '.' . request()->file('avatar')->getClientOriginalExtension();
        $image->save(storage_path('app/public/' . $fileName));

        $attributes['slug'] = Str::slug($attributes['name']);
        $attributes['avatar'] = $fileName;

        Group::create($attributes);
        return redirect('groups.index');
    }
}
