<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'group_user',
            'user_id',
            'group_id'
        );
    }

    //TODO -> database functions or some query chaining
    public function active_groups()
    {
$groups =$this->groups;

return $groups->filter( function ($group, $key){
    return $this->getGroupBilance($group) !=0;
});
    }


    public function expenses()
    {
        return $this->belongsToMany(
            Expense::class,
            'expenses_user',
            'user_id',
            'expenses_id'
        );
    }

    public function payments_executed(){
        return $this->hasMany(Payment::class, 'user_1_id');
    }
    public function payments_recived(){
        return $this->hasMany(Payment::class, 'user_2_id');
    }
    public function invites(){

        return $this->hasMany(Invites::class);
    }

    public function isIncluded(ExpensesHistory $expense_history){

    return $expense_history->users()->contains($this);

    }

    public function userContribution(ExpensesHistory $expense_history){

        $result= \DB::table('expenses_user')->where('user_id','=',$this->id)->where('expenses_history_id','=',$expense_history->id)->select('user_contribution')->get()->first();
        return $result;

    }
    public function balanceInGroup(){}

//    public function balancePaymentInGroup(Group $group){
//
//
// $plus=$this->expenses()->where('group_id','=',$group->id)->join('expenses_histories','expenses_histories.expense_id','=','expenses.id')->where('expenses_histories.isLatest','=',1)->where('expenses_histories.action','!=',3)->select('amount')->sum('amount');
//
//
//
//
//    $minus= $this->expenses()->where('group_id','=',$group->id)->join('expenses_histories','expenses_histories.expense_id','=','expenses.id')->where('expenses_histories.isLatest','=',1)->join('expenses_user','expenses_histories.id','=','expenses_user.expenses_history_id')->where('expenses_user.user_id','=',$this->id)->sum('user_contribution');
//
//return $plus-$minus;
//
//
//    }



    public function owes(ExpensesHistory $expense_history){


        $amount=$this->userContribution();

                if(!is_null($expense_history->item )){
                    return   $amount." " . $expense_history->item ;
                }else{

                    return  $amount;
                }

    }

    public function getBack(ExpensesHistory $expense_history){

       $amount=$expense_history->amount - $this->userContribution($expense_history);
        if(!is_null($expense_history->item )){
            return   $amount." " . $expense_history->item ;
        }else{

            return  $amount;
        }
    }


    public function whomOwe(Group $group){
         $users_id = DB::table('expenses_user')
            ->where('expenses_user.user_id', $this->id)
            ->join('expenses_histories','expenses_user.expenses_history_id',
                '=','expenses_histories.id')
            ->join('expenses','expenses_histories.expense_id',
                '=','expenses.id')
             ->pluck('expenses.user_id')->toArray();

         return User::whereIn('id',$users_id)->get();

    }

    public function getGroupBilance(Group $group){

        $amount = ExpensesHistory::whereHas('expense', function($q) use ($group) {
            $q->where('user_id', $this->id);
            $q->where('group_id', $group->id);
            $q->where('isLatest', 1);
            $q->where('action', '!=','3');

        })->sum('amount');

        $contribution = DB::table('expenses_user')
            ->where('expenses_user.user_id', $this->id)
            ->join('expenses_histories','expenses_user.expenses_history_id',
                '=','expenses_histories.id')->where('expenses_histories.isLatest','=', 1)->where('expenses_histories.action','!=', 3)
            ->join('expenses','expenses_histories.expense_id',
                '=','expenses.id')
            ->where('group_id', $group->id)->sum('user_contribution');

        return($amount - $contribution);

    }

    public  function getBilance(){
        $amount = ExpensesHistory::whereHas('expense', function($q)  {
            $q->where('user_id', $this->id);
            $q->where('isLatest', 1);
            $q->where('action', '!=','3');
        })->sum('amount');

        $contribution = DB::table('expenses_user')
            ->where('expenses_user.user_id', $this->id)
            ->join('expenses_histories','expenses_user.expenses_history_id',
                '=','expenses_histories.id')->where('expenses_histories.isLatest','=', 1)->where('expenses_histories.action','!=', 3)
            ->join('expenses','expenses_histories.expense_id',
                '=','expenses.id')
            ->sum('user_contribution');
        return($amount-$contribution);

    }



//    public function getUserContribution(Expense $expense){
////
////        $result= DB::table('users')->join('expenses_user', 'expenses_user.user_id', '=','users.id')->where('expenses_user.expenses_id','=',$expense->id)->get();
////        ddd($result);
//        return 10;
//}


    public function getExpenseString(Expense $expense){
//
//        $result= DB::table('users')->join('expenses_user', 'expenses_user.user_id', '=','users.id')->where('expenses_user.expenses_id','=',$expense->id)->get();
//        ddd($result);

        return 10;
    }




}
