<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Models\Payment;
use App\Services\GroupService;
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


    public function store(GroupRequest $request, GroupService $service)
    {

        if (!empty($request->avatar)) {
            $imagePath = $service->getImage($request);
        } else {
            $imagePath = '/images/default_group.png';
        }

        $group = Group::create([
            'name' => $request->get('name'),
            'user_id' => auth()->user()->id,
            'avatar' => $imagePath,
        ]);
        $group->users()->attach(auth()->user()->id);

        return redirect(route('groups.index'))->with('success', 'Group has been created');
    }

    public function show(Group $group, GroupService $service)
    {
        Gate::authorize('member', $group);
        $expenses_history = Group::find($group->id)->expenses_history()->orderBy('created_at', 'desc')->get();
        $payments = auth()->user()->getPaymentHistoryInGroup($group);

        $merged = $service->mergeArrays($expenses_history, $payments);

        return view('groups.show', ['group' => $group, 'expenses_payments' => $merged]);
    }

    public function edit(Group $group)
    {
        return view('groups.edit')->withGroup($group)->withUsers($group->users);
    }

    public function update(Group $group, GroupRequest $request, GroupService $service)
    {

        if ($request->file('avatar')) {

            $imagePath = $service->getImage($request);
            File::delete($group->avatar);

            $group->avatar = $imagePath;
        }

        $group->name = $request->get('name');
        $group->save();

        return redirect(route('groups.show', $group))->with('success', 'Group has been edited');

    }

    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Group has been deleted');
    }

}



