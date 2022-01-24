<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Payment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\isEmpty;


class GroupController extends Controller {

    public function index()
    {
        return view('groups.index', ['groups' => auth()->user()->groups]);
    }


    public function create()
    {
        return view('groups.create');
    }


    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'avatar' => 'image|mimes:jpg,png|max:2048',
            'smart_billing' => 'boolean',
        ]);

        if (!empty(request()->avatar)){
            $fileExtension = request()->file('avatar')->getClientOriginalExtension();
            $fileNameToStore = time().'.'.$fileExtension;
            request()->avatar->move(storage_path('app/public/group_avatars/'),$fileNameToStore);
            $imagePath = 'storage/group_avatars/'.$fileNameToStore;
        }else{
            $imagePath = '/images/default_group.png';
        }

        $group = Group::create([
            'name' => $attributes['name'],
            'user_id' => auth()->user()->id,
            'avatar' => $imagePath,
            'smart_billing' => $attributes['smart_billing'] ?? 0
        ]);


        $group->users()->attach(auth()->user()->id);
        return redirect(route('groups.index'))->with('success', 'Group has been created');
    }

    public function show(Group $group)
    {
        Gate::authorize('member', $group);
        $expenses_history= Group::find($group->id)->expenses_history()->orderBy('created_at','desc')->get();



$payments=auth()->user()->getPaymentHistoryInGroup($group );

$merged=array_merge($expenses_history->all(), $payments->all());

usort($merged, function($a,$b){
    $tmp1 = strtotime($a['created_at']);
    $tmp2 = strtotime($b['created_at']);
    return  $tmp2 - $tmp1;
});

        auth()->user()->whomOwe($group);
        return view('groups.show', ['group' => $group, 'expenses_payments'=>$merged]);
    }

    public function edit(Group $group)
    {
        return view('groups.edit')->withGroup($group)->withUsers($group->users);
    }

    public function update(Group $group)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'avatar' => 'image|mimes:jpg,png|max:2048',
            'smart_billing' => 'boolean',
        ]);

        if(request()->file('avatar')) {
            $fileName = time() . '.' . request()->file('avatar')->getClientOriginalExtension();
            request()->avatar->move(storage_path('app/public/group_avatars/'), $fileName);
            $imagePath = '/storage/group_avatars/' . $fileName;

            File::delete($group->avatar);

            $group->avatar = $imagePath;
        }
        $group->name = $attributes['name'];
        $group->smart_billing = $attributes['smart_billing'] ?? 0;

        $group->save();
        return redirect(route('groups.show', $group))->with('success', 'Group has been edited');

    }

    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Group has been deleted');
    }

}



