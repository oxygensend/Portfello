<?php

namespace App\Actions;

use App\Models\Payment;
use App\Models\User;

class GetHistory {

    public function execute($users, $expenses_history) {

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

        return $merged;
    }
}
