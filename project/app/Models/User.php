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
    return $this->getGroupBalance($group) !=0;
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


        $amount=$this->contributonInExpense($expense_history);

                if(!is_null($expense_history->item )){
                    return   $amount." " . $expense_history->item ;
                }else{

                    return  $amount;
                }

    }

    public function getBack(ExpensesHistory $expense_history){

       $amount=$expense_history->amount - $this->contributonInExpense($expense_history);
        if(!is_null($expense_history->item )){
            return   $amount." " . $expense_history->item ;
        }else{

            return  $amount;
        }
    }


    public function whomOwe(Group $group)
    {
        $users_id = DB::table('expenses_user')
            ->where('expenses_user.user_id', $this->id)
            ->join('expenses_histories','expenses_user.expenses_history_id',
                '=','expenses_histories.id')
            ->join('expenses','expenses_histories.expense_id',
                '=','expenses.id')
             ->pluck('expenses.user_id')->toArray();

         return User::whereIn('id',$users_id)->get();

    }

    public function getGroupBalance(Group $group)
    {


        $amount = ExpensesHistory::whereHas('expense', function($q) use ($group) {
            $q->where('user_id', $this->id);
            $q->where('group_id', $group->id);
            $q->where('isLatest', 1);
            $q->where('item', null);
            $q->where('action', '!=','3');

        })->sum('amount');


        $payments_recived = $this->payments_recived()->where('group_id',$group->id)->sum('amount');
        $payments_executed = $this->payments_executed()->where('group_id',$group->id)->sum('amount');

        $contribution = DB::table('expenses_user')
            ->where('expenses_user.user_id', $this->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->join('expenses', 'expenses_histories.expense_id',
                '=', 'expenses.id')
            ->where('group_id', $group->id)
            ->where('expenses_histories.action', '!=', 3)
            ->where('expenses_histories.isLatest', true)
            ->where('item', null)
            ->sum('user_contribution');

        return($amount - $contribution - $payments_recived + $payments_executed);

    }

    public function getBalance()
    {
        $amount = ExpensesHistory::whereHas('expense', function ($q) {
            $q->where('user_id', $this->id);
            $q->where('isLatest', 1);
            $q->where('action', '!=','3');
            $q->where('item', null);
        })->sum('amount');

        $payments_recived = $this->payments_recived()->sum('amount');
        $payments_executed = $this->payments_executed()->sum('amount');

        $contribution = DB::table('expenses_user')
            ->where('expenses_user.user_id', $this->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->join('expenses', 'expenses_histories.expense_id',
                '=', 'expenses.id')
            ->where('expenses_histories.action', '!=', 3)
            ->where('expenses_histories.isLatest', true)
            ->where('item', null)
            ->sum('user_contribution');
        return($amount-$contribution - $payments_recived + $payments_executed);

    }

    public function getBalanceWithUser(User $user, Group $group){

        $payments_recived = $this->payments_recived()->where('group_id',$group->id)->where('user_1_id', $user->id)->sum('amount');
        $payments_executed = $this->payments_executed()->where('group_id',$group->id)->where('user_2_id', $user->id)->sum('amount');
        $user_contribution = DB::table('expenses_user')
            ->where('expenses_user.user_id', $user->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->join('expenses', 'expenses_histories.expense_id',
                '=', 'expenses.id')
            ->where('expenses_histories.action', '!=', 3)
            ->where('expenses_histories.isLatest', true)
            ->where('expenses.id', $this->id)
            ->where('item', null)
            ->sum('user_contribution');
        $my_contribution = DB::table('expenses_user')
            ->where('expenses_user.user_id',$this->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->join('expenses', 'expenses_histories.expense_id',
                '=', 'expenses.id')
            ->where('expenses.id', $user->id)
            ->where('expenses_histories.action', '!=', 3)
            ->where('expenses_histories.isLatest', true)
            ->where('item', null)
            ->sum('user_contribution');
        return($user_contribution - $my_contribution -$payments_recived + $payments_executed);
    }

    public function getItemBalance()
    {

        $balance = DB::table('expenses_user')
            ->where('expenses_user.user_id', $this->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->join('expenses', 'expenses_histories.expense_id',
                '=', 'expenses.id')
            ->where('expenses_histories.action', '!=', 3)
            ->where('expenses_histories.isLatest', true)
            ->where('item','!=', null)
            ->select('expenses_histories.item', 'expenses_user.user_contribution','expenses_histories.amount')
            ->groupBy('item')->selectRaw(' item, sum(amount) as amount , sum(user_contribution) as user_contribution, sum(amount-user_contribution) as balance ')
            ->pluck('balance', 'item');


        return($balance);

    }

    public function getGroupItemBalance($group){

        $balance = DB::table('expenses_user')
            ->where('expenses_user.user_id', $this->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->join('expenses', 'expenses_histories.expense_id',
                '=', 'expenses.id')
            ->where('expenses.group_id', $group->id)
            ->where('expenses_histories.action', '!=', 3)
            ->where('expenses_histories.isLatest', true)
            ->where('item','!=', null)
            ->select('expenses_histories.item', 'expenses_user.user_contribution','expenses_histories.amount')
            ->groupBy('item')->selectRaw(' item, sum(amount) as amount , sum(user_contribution) as user_contribution, sum(amount-user_contribution) as balance ')
            ->pluck('balance', 'item');


        return($balance);

    }

    public function contributonInExpense(ExpensesHistory $expense){

        return DB::table('expenses_user')
            ->where('expenses_user.user_id', $this->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->where('expense_id',$expense->id)
            ->where('action', '!=', 3)
            ->where('isLatest', true)
            ->value('user_contribution');
    }
  public function CurrnetExpenseswithGroup()
    {
        return $this->hasManyThrough(ExpensesHistory::class, Expense::class,
            '',
            '',
            'id',
            'id',
        )->join('groups','groups.id','=','expenses.group_id');
    }
    public function expenses_history()
    {
        return $this->hasManyThrough(ExpensesHistory::class, Expense::class,
            '',
            '',
            'id',
            'id',
        );
    }
    public function getExpenseString(Expense $expense){
//
//        $result= DB::table('users')->join('expenses_user', 'expenses_user.user_id', '=','users.id')->where('expenses_user.expenses_id','=',$expense->id)->get();
//        ddd($result);

        return 10;
    }




}
