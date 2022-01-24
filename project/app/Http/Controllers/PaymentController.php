<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpensesHistory;
use App\Models\Group;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use function PHPUnit\Framework\at;

class PaymentController extends Controller
{
    //


    public function create(Group $group){

        return view('payments.create',['group'=>$group]);

    }



    public function getItemsList(Group $group, User $user){


       $items= \Auth::user()->getItemBalanceWithUser($user, $group);
//todo
        $filtered=[];
        foreach($items  as $key => $value){
            if($value<0) $filtered[$key]=$value;
        }

        return json_encode($filtered);

    }



    public function store(Group $group){

        $user = auth()->user();


            $attributes = request()->validate([
                'select_user' => 'required:in:' . $user->whomOwe($group),
                'item_select' => 'nullable',
                'how_much' => 'required|numeric|min:0.01'
            ]);


            $user2 = User::find($attributes['select_user']);
            if($attributes['how_much'] > abs($user->getBalanceWithUser($user2, $group)) && ($attributes['item_select']??null) == null){
                throw ValidationException::withMessages(['how_much'=>'Too large payment amount']);
            }



        Payment::create([
            'user_1_id' => auth()->user()->id,
            'user_2_id' => $attributes['select_user'],
            'item' => ($attributes['item_select'] ?? null),
            'amount' => $attributes['how_much'],
            'group_id' => $group->id
        ]);


        return redirect(route('groups.show', $group))->with('success','Payment done');

    }
}
