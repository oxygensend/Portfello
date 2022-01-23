<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $expenses_history= Auth::user()->expenses_history()->orderBy('created_at','desc')->get();

        $users=DB::table('expenses_user')->where('expenses_user.user_id','=',auth()->user()->id)
            ->join('expenses_histories','expenses_user.expenses_history_id','=','expenses_histories.id')
            ->join('expenses','expenses.id','=','expenses_histories.expense_id')->get(['expenses_histories.id','expenses.user_id']);

        foreach($users as $user) {
            $temp=User::find($user->user_id)->expenses_history()->where('expenses_histories.id','=',$user->id)->get() ;
            $expenses_history=$expenses_history->merge($temp);
        }

        $payments=auth()->user()->getPaymentHistory( );

        $merged=array_merge($expenses_history->all(), $payments->all());

        usort($merged, function($a,$b){
            $tmp1 = strtotime($a['created_at']);
            $tmp2 = strtotime($b['created_at']);
            return  $tmp2 - $tmp1;
        });



       return view('history', [ 'expenses_payments'=>$merged]);
    }
}
