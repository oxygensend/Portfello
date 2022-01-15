<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Nette\Schema\ValidationException;

class GroupExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        $expenses = Group::find($group->id)->expenses;

        return view('expenses.index')->withGroup($group)->withExpenses($expenses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group)
    {
        return view('expenses.create')->withGroup($group)->withUsers($group->users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseRequest $request,Group $group)
    {

        $attributes = request()->validate([
            'name' => ['required', Rule::exists('users', 'name')],
            'how_much' => 'required|numeric',
        ]);
        $user_2 = DB::table('users')->where('name', request('name'))->first();
        $user_1= auth()->user();
        $expense = new Expense();
        $expense->group_id=$group->id;
        $expense->amount = $request->how_much;
        $expense->item = "dsa";
        $expense->description = "description";
        $expense->save();
        DB::table('expenses_user')->insert([
            [
            'user_1_id'=>$user_1->id,
            'user_2_id'=>$user_2->id,
            'expenses_id'=>$expense->id,
            ],
        ]);

        return view('expenses.create')->withGroup($group)->withUsers($group->users);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpenseRequest  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
