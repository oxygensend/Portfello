<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpensesHistory;
use App\Models\Group;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //


    public function create(Group $group, ExpensesHistory $expense){

        return view('payments.create',['group'=>$group, 'expense'=> $expense]);

    }

    public function store(Group $group, ExpensesHistory $expense){


        if($expense->item == NULL) {
            $attributes = request()->validate([
                'amount' => 'required|numeric|min:0.01|max:' . auth()->user()->contributonInExpense($expense)
            ]);
        }
        else {
            $attributes['amount'] = auth()->user()->contributonInExpense($expense);
            $attributes['item'] = $expense->item;
        }
        $attributes['user_1_id'] = auth()->user()->id;
        $attributes['user_2_id'] = $expense->user->id;
        $attributes['group_id'] = $group->id;

        \DB::table('expenses_user')->where('expenses_user.user_id', $attributes['user_1_id'])
            ->where('expenses_history_id', $expense->id)
            ->join('expenses_histories', 'expenses_histories.id', 'expenses_user.expenses_history_id')
            ->join('expenses', 'expenses.id', 'expenses_histories.expense_id')
            ->where('group_id', $attributes['group_id'])
            ->decrement('user_contribution', $attributes['amount']);
        Payment::create($attributes);

        $msg = auth()->user()->contributonInExpense($expense) ? "Money has been returned" : "You have paid your debt";

        return redirect(route('groups.expenses.show', [$group,$expense]))->with('success',$msg);

    }
}
