<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Models\ExpensesHistory;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Nette\Schema\ValidationException;

class GroupExpenseController extends Controller
{

    public function index(Group $group)
    {
        $user_expenses=auth()->user()->expenses;
        $user_expenses->where('group_id','=',$group->id);
        ddd($user_expenses);
        return view('expenses.index',['result'=>$user_expenses])->withGroup($group);
    }


    public function create(Group $group)
    {
        $new_id=auth()->user()->id;
        return view('expenses.create')->withGroup($group)->withUsers($group->users->where('id', '!=', $new_id));
    }


    public function store(StoreExpenseRequest $request,Group $group)
    {

        $attributes = request()->validate([
            'description' => 'required',
            'selected_users' => 'required',
            'item' => 'nullable',
            'how_much' => 'required | numeric',

        ]);
//        ddd('dumping this one', $request);
        $user= auth()->user();
        $selected_users=$request->selected_users;
       $expense = Expense::create([
            'group_id'=>$group->id,
            'user_id'=>$user->id,
        ]
        );
        $expense_history = ExpensesHistory::create([
            'expense_id'=>$expense->id,
            'action'=>1, // 1 - add 2 - update 3 - delete
            'amount'=>$attributes['how_much'],
            'item'=>$attributes['item'],
            'title'=>$attributes['description'],
        ]);

        foreach($attributes['selected_users'] as $user){
            DB::table('expenses_user')->insert([
                    'user_id'=>$user,
                    'expenses_history_id'=>$expense_history->id,
                    'user_contribution' => round($expense_history->amount/count($attributes['selected_users']),2),
            ]);



        }
        $expenses_history= Group::find($group->id)->expenses_history;
        return redirect(route('groups.show', ['group' => $group,'expenses_history' =>$expenses_history]));
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

    public function show(Group $group,ExpensesHistory $expense)
    {
        return view('expenses.show ')->with(['expense' =>$expense])->withGroup($group);
    }


    public function edit(Expense $expense)
    {
        //
    }


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
