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
        return view('groups.index', ['groups' => Group::paginate(4)]);
    }


    public function create()
    {
        return view('groups.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'avatar' => 'image',
            'smart_billing' => 'boolean'
        ]);
        if ($attributes['avatar'] ?? false) {
            $image =  Image::make(request()->file('avatar'));
            $fileName   = 'group_avatars/' . time() . '.' . request()->file('avatar')->getClientOriginalExtension();
            $image->save(storage_path('app/public/' . $fileName));
        } else {
            $fileName = 'group_avatars/default_group.png';
        }
        
        $attributes['slug'] = Str::slug($attributes['name']);
        $attributes['avatar'] = $fileName;
        $attributes['user_id'] = auth()->user()->id;

        Group::create($attributes);
        return redirect(route('groups.index'));
    }

    public function show(Group $group)
    {
        return view('groups.show', ['group' => $group]);
    }
}
