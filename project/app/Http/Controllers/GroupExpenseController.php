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
        $user_expenses=auth()->user()->expenses;
        $user_expenses=$user_expenses->where('group_id','=',$group->id)
            ->join('expenses_user', 'expenses_user.expenses_id','=','expenses.id')
            ->users;
        $group_expenses=$group->expenses();
        ddd($group_expenses);
        return view('expenses.index',['result'=>$user_expenses])->withGroup($group);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group)
    {
        $new_id=auth()->user()->id;
        return view('expenses.create')->withGroup($group)->withUsers($group->users->where('id', '!=', $new_id));
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
            'item' => 'nullable',
            'how_much' => 'required|numeric',
            'description'=> 'nullable',
        ]);

        $user_2 = DB::table('users')->where('name', request('name'))->first();
        $user_1= auth()->user();
        $expense = new Expense();
        $expense->group_id=$group->id;
        $expense->amount = $request->how_much;
        $expense->item = $request ->item;

        $expense->description = $request->description;
        $expense->save();
        DB::table('expenses_user')->insert([
            [
            'user_1_id'=>$user_1->id,
            'user_2_id'=>$user_2->id,
            'expenses_id'=>$expense->id,
            ],
        ]);
        $expenses = Group::find($group->id)->expenses;

        $result=$this->my_join($group);
        return view('expenses.index',['result'=>$result])->withGroup($group)->withExpenses($expenses);
    }

    private function my_join(Group $group){

        $plus = DB::table('expenses')->where('group_id', $group->id)
            ->join('expenses_user','expenses.id', '=', 'expenses_user.expenses_id')
            ->join('users', 'expenses_user.user_2_id', '=', 'users.id')
            ->where('expenses_user.user_1_id','=',auth()->user()->id)
            ->orderBy('expenses.updated_at', 'desc')->get();
        $minus = DB::table('expenses')->where('group_id', $group->id)
            ->join('expenses_user', 'expenses.id', '=', 'expenses_user.expenses_id')
            ->join('users', 'expenses_user.user_1_id', '=', 'users.id')
            ->where('expenses_user.user_2_id','=',auth()->user()->id)
            ->orderBy('expenses.updated_at', 'desc')
            ->get();
        foreach ($minus as $m)
            $m->amount= $m->amount*-1;
        $result=$plus->merge($minus);
        //TODO nie dziala helpppp
        return $result->sortBy('updated_at',SORT_REGULAR, TRUE);
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
