<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Models\ExpensesHistory;
use App\Models\Group;
use App\Rules\SelectedUsers;
use App\Rules\SelectedUsersAuthor;
use App\Services\GroupExpenseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\User;

use Nette\Schema\ValidationException;

class GroupExpenseController extends Controller {

    public function index(Group $group)
    {
        $user_expenses = auth()->user()->expenses()->where('group_id', '=', $group->id);
        return view('expenses.index', ['result' => $user_expenses])->withGroup($group);
    }


    public function create(Group $group)
    {
        $new_id = auth()->user()->id;
        return view('expenses.create')->withGroup($group)->withUsers($group->users()->where('id', '!=', $new_id));
    }


    public function store(StoreExpenseRequest $request, Group $group, GroupExpenseService $service)
    {

        $expense = Expense::create([
                'group_id' => $group->id,
                'user_id' => Auth::id(),
            ]
        );
        $expense_history = ExpensesHistory::create([
            'expense_id' => $expense->id,
            'action' => 1, // 1 - add 2 - update 3 - delete
            'amount' => $request->get('how_much'),
            'item' => $request->get('item'),
            'title' => $request->get('description'),
        ]);

        $service->insertExpenseRelation($expense_history, $request->get('selected_users'));

        $expenses_history = Group::find($group->id)->expenses_history;
        return redirect(route('groups.show', ['group' => $group, 'expenses_history' => $expenses_history]));
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


    public function update(UpdateExpenseRequest $request, Group $group, ExpensesHistory $expense, GroupExpenseService $service)
    {

        $expense->title = $request->title;
        $expense->item = $request->item;
        $expense->amount = $request->how_much;
        $attributes_changed = $expense->isDirty();

        $previous_users = $expense->users();
        $users_changed = $service->checkUserChange($previous_users, $request->get('selected_users'));

        $old_expense = ExpensesHistory::findOrFail($expense->id);

        if ($users_changed || $attributes_changed) {

            $old_expense->isLatest = false;
            $old_expense->save();

            $expense_history_new = ExpensesHistory::create([
                'expense_id' => $old_expense->expense_id,
                'action' => 2, // 1 - add 2 - update 3 - delete
                'amount' => $expense->amount,
                'item' => $expense->item,
                'title' => $expense->title,
            ]);

            $service->insertExpenseRelation($expense_history_new, $request->get('selected_users'));

        } else {

            return redirect(route('groups.expenses.show', ['group' => $group, 'expense' => $old_expense]));

        }

        return redirect(route('groups.show', ['group' => $group]));

    }


    public function destroy(Group $group, ExpensesHistory $expense, GroupExpenseService $service)
    {
        if ($expense->isLatest == true && $expense->action == 3) {
            return redirect(route('groups.expenses.show', ['group' => $group, 'expense' => $expense]));
        }

        $expense_history_new = ExpensesHistory::create([
            'expense_id' => $expense->expense_id,
            'action' => 3, // 1 - add 2 - update 3 - delete
            'amount' => $expense->amount,
            'item' => $expense->item,
            'title' => $expense->title,
        ]);

        $expense->update(['isLatest' => false]);
        $service->insertExpenseRelation($expense_history_new, $expense->users()->pluck('id')->toArray());

        return redirect(route('groups.show', ['group' => $group]));

    }
}
