<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExpensesHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'action',
        'amount',
        'item',
        'title',
    ];

    public function getAmountString(){
        $str=$this->amount;
        if(!empty($this->item)  ) $str.=" ".$this->item;
//        else $str.=" "; TODO: currency
        return $str;

    }
    public function user(){
//        return $this->hasManyThrough(User::class, Expense::class,
//        'expense_id','id','id','creator'
//
//        );
return $this->expense->user();

    }

    public function users(){
//
      return DB::table('expenses_histories')->where('expenses_histories.id','=',$this->id)
          ->join('expenses_user','expenses_histories.id','=','expenses_user.expenses_history_id')
          ->join('users','users.id','=','expenses_user.user_id')
          ->select('users.*' ,'expenses_user.user_contribution')->get();


    }


    public function expense(){
        return $this->belongsTo(Expense::class);
    }



    public function group(){
        return $this->expense->group();

    }



    public function getStringAction(){

        $actions= [1=>'added' ,'edited', 'deleted'];
        return $actions[$this->action];

}
    public function getDay(){

        if(empty($this->created_at))return "None";
        return $this->created_at->format('j') ;

    }

    public function getMonth(){
        if(empty($this->created_at))return "None";
        return $this->created_at->format('M') ;

    }

    public function getDate(){
        if(empty($this->created_at))return "No date specified";
        return $this->created_at->format('j F Y') ;

    }





}
