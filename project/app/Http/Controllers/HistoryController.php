<?php

namespace App\Http\Controllers;

use App\Actions\GetHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller {

    /**
     * @param Request $request
     * @param GetHistory $getHistory
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function __invoke(Request $request, GetHistory $getHistory)
    {

        $expenses_history = Auth::user()->expenses_history()->orderBy('created_at', 'desc')->get();

        $users = DB::table('expenses_user')->where('expenses_user.user_id', '=', auth()->user()->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id', '=', 'expenses_histories.id')
            ->join('expenses', 'expenses.id', '=', 'expenses_histories.expense_id')->get(['expenses_histories.id', 'expenses.user_id']);


        $history = $getHistory->execute($users, $expenses_history);

        return view('history', ['expenses_payments' => $history]);
    }
}
