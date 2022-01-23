<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpensesHistory;
use App\Models\Group;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
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


        //jesli wgl sa takie itemy
       $items= \Auth::user()->getItemBalanceWithUser($user, $group);
        return json_encode($items);

    }



    public function store(Group $group){

        $user = auth()->user();

            $attributes = request()->validate([
                'selected_user' => 'required:in:' . $user->whomOwe($group),
                'item' => 'nullable',
                'how_much' => 'required|numeric'
            ]);


            $user2 = User::find($attributes['selected_user']);
            if($attributes['how_much'] > abs($user->getBalanceWithUser($user2, $group)) && $attributes['item'] == null){
                throw ValidationException::withMessages(['how_much'=>'to much']);
            }



        Payment::create([
            'user_1_id' => auth()->user()->id,
            'user_2_id' => $attributes['selected_user'],
            'item' => $attributes['item'],
            'amount' => $attributes['how_much'],
            'group_id' => $group->id
        ]);


        return redirect(route('groups.show', $group))->with('success','transfer ok');

    }
}
