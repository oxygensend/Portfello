<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Models\ExpensesHistory;
use App\Models\Group;
use App\Rules\SelectedUsers;
use App\Rules\SelectedUsersAuthor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\User;

use Nette\Schema\ValidationException;

class GroupExpenseController extends Controller
{

    public function index(Group $group)
    {
        $user_expenses = auth()->user()->expenses;
        $user_expenses->where('group_id', '=', $group->id);
        ddd($user_expenses);
        return view('expenses.index', ['result' => $user_expenses])->withGroup($group);
    }


    public function create(Group $group)
    {
        $new_id = auth()->user()->id;
        return view('expenses.create')->withGroup($group)->withUsers($group->users->where('id', '!=', $new_id));
    }


    public function store(StoreExpenseRequest $request, Group $group)
    {

        $attributes = request()->validate([
            'description' => 'required',
            'selected_users' => 'required',
            'item' => 'nullable',
            'how_much' => 'required | numeric|min:0.1',

        ]);



//        ddd('dumping this one', $request);
        $user = auth()->user();
        $selected_users = $request->selected_users;
        $expense = Expense::create([
                'group_id' => $group->id,
                'user_id' => $user->id,
            ]
        );
        $expense_history = ExpensesHistory::create([
            'expense_id' => $expense->id,
            'action' => 1, // 1 - add 2 - update 3 - delete
            'amount' => $attributes['how_much'],
            'item' => $attributes['item'],
            'title' => $attributes['description'],
        ]);

        foreach ($attributes['selected_users'] as $user) {
            DB::table('expenses_user')->insert([
                'user_id' => $user,
                'expenses_history_id' => $expense_history->id,
                'user_contribution' => round($expense_history->amount / count($attributes['selected_users']), 2),
            ]);



        }
        $expenses_history= Group::find($group->id)->expenses_history;
        return redirect(route('groups.show', ['group' => $group,'expenses_history' =>$expenses_history]));
    }

    private function my_join(Group $group)
    {

        $plus = DB::table('expenses')->where('group_id', $group->id)
            ->join('expenses_user', 'expenses.id', '=', 'expenses_user.expenses_id')
            ->join('users', 'expenses_user.user_2_id', '=', 'users.id')
            ->where('expenses_user.user_1_id', '=', auth()->user()->id)
            ->orderBy('expenses.updated_at', 'desc')->get();
        $minus = DB::table('expenses')->where('group_id', $group->id)
            ->join('expenses_user', 'expenses.id', '=', 'expenses_user.expenses_id')
            ->join('users', 'expenses_user.user_1_id', '=', 'users.id')
            ->where('expenses_user.user_2_id', '=', auth()->user()->id)
            ->orderBy('expenses.updated_at', 'desc')
            ->get();
        foreach ($minus as $m)
            $m->amount = $m->amount * -1;
        $result = $plus->merge($minus);
        //TODO nie dziala helpppp
        return $result->sortBy('updated_at', SORT_REGULAR, TRUE);
    }

    public function show(Group $group, ExpensesHistory $expense)
    {
        return view('expenses.show ')->with(['expense' => $expense])->withGroup($group);
    }


    public function edit(Group $group, ExpensesHistory $expense)
    {
        Gate::authorize('expense_creator', $expense);
        return view('expenses.edit ')->with(['expense' => $expense])->withGroup($group);
    }


    public function update(UpdateExpenseRequest $request, Group $group, ExpensesHistory $expense)
    {



        $attributes = request()->validate([
            'title' => 'required',
            'selected_users' => ['required', new SelectedUsers() , new SelectedUsersAuthor()] ,
            'item' => 'nullable',
            'how_much' => 'required | numeric|min:0.1',
        ]);


        $expense->title = $request->title;
        $expense->item = $request->item;
        $expense->amount = $request->how_much;



        $attributes_changed =  $expense->isDirty();

        $previous_users = $expense->users() ;
        $previous_users_ids=[];

        foreach(       $previous_users as $user){
            array_push($previous_users_ids, $user->id);
        }


        $new_users_ids=array_map('intval',$attributes['selected_users']);


        if (sizeof($previous_users_ids) == sizeof($new_users_ids) ){

            $diff = array_diff($previous_users_ids, $new_users_ids);
            if (sizeof($diff) == 0) $users_changed = false;
            else $users_changed = true;
        } else {
            $users_changed = true;
        }
        $old_expense = ExpensesHistory::find($expense->id);

        if ($users_changed || $attributes_changed) {


            $old_expense->isLatest = false;
            $old_expense->save();

            $expense_history_new = ExpensesHistory::create([

                'expense_id' => $old_expense->expense_id,
                'action' => 2, // 1 - add 2 - update 3 - delete
                'amount' => $expense->amount,
                'item' => $expense->item,
                'title' =>$expense->title
            ]);


            foreach ($attributes['selected_users'] as $user) {
                DB::table('expenses_user')->insert([
                    'user_id' => $user,
                    'expenses_history_id' => $expense_history_new->id,
                    'user_contribution' => round($expense_history_new->amount / count($attributes['selected_users']), 2),
                ]);

            }


        } else {

//redirect back
            //todo - shouldnt be changed

            return redirect(route('groups.expenses.show', ['group' => $group, 'expense' => $old_expense]));

        }


        return redirect(route('groups.show', ['group' => $group]));


    }


    public function destroy(Group $group,ExpensesHistory $expense)
    {
        if($expense->isLatest == true && $expense->action ==3){

            return redirect(route('groups.expenses.show', ['group' => $group ,'expense'=>$expense]));

        }



        $expense_history_new = ExpensesHistory::create([
            'expense_id' => $expense->expense_id,
            'action' => 3, // 1 - add 2 - update 3 - delete
            'amount' => $expense->amount,
            'item' => $expense->item,
            'title' =>$expense->title
        ]);

        $expense->isLatest=false;
        $expense->save();
        $users= $expense->users() ;

        foreach ($users as  $user) {
            DB::table('expenses_user')->insert([
                'user_id' => $user->id,
                'expenses_history_id' => $expense_history_new->id,
                'user_contribution' => round($expense_history_new->amount / count($users), 2),
            ]);

        }

        return redirect(route('groups.show', ['group' => $group]));




    }
}
