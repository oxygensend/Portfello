<?php

namespace App\Models;

use Codeception\Subscriber\GracefulTermination;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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
        $id=DB::table('expenses_histories')->join('expenses_user','expenses_user.expenses_history_id','=','expenses_histories.id')
            ->where('expenses_user.expenses_history_id','=',$expense_history->id)->get('user_id')->toArray();

        foreach($id as $i){
            if($i->user_id==$this->id)
                return true;
        }

        return false;

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

    private function  combineArrays($a1, $a2, $a3) : Collection {
        $sums = array();
        foreach (array_keys($a1 + $a2 + $a3) as $key) {
            $sums[$key] = @($a1[$key] + $a2[$key] - $a3[$key]);
        }

        return collect($sums);

    }

    public function owes(ExpensesHistory $expense_history){


        $amount=$this->contributonInExpense($expense_history);

                if(!is_null($expense_history->item )){
                    return   [$amount, $expense_history->item];
                }else{

                    return  [$amount,null];
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

    public function getPaymentHistoryInGroup(Group $group){

       $ids=  $this->paymentHistoryInGroup($group)->get();


  $ids= array_map( function($value){
  return $value->id;

  } , $ids->toArray() );


 return Payment::findMany( $ids);


    }
    public function getPaymentHistory(){

        $ids=  $this->paymentHistory()->get();

        $ids= array_map( function($value){
            return $value->id;

        } , $ids->toArray() );


        return Payment::findMany( $ids);

    }

    public function paymentHistoryInGroup(Group $group){

    return $this->paymentHistory()->where('payments.group_id',$group->id );

    }
    public function paymentHistory(){

        $user=auth()->user();

      return  $payments = DB::table('payments')->join('groups','payments.group_id','=','groups.id')->join('group_user', 'group_user.group_id','=','groups.id')->where('group_user.user_id','=',$user->id)->select('payments.*');
//how to convert query to models?? TODO


    }


    public function whomOwe(Group $group)
    {

        $whomOweMoney=[];
        $whomOweItems=[];

        forEach($group->users as $user){

            if($user->is(auth()->user())  ) continue;



                $balance = $this->getBalanceWithUser($user, $group);
//            ddd([$user, $balance]);


                if($balance < 0 ) $whomOweMoney[$user->id] = 1;

                $balance_array = $this->getItemBalanceWithUser($user,$group);


                foreach($balance_array as $balance_item){
                    if($balance_item <0 ){
                        $whomOweItems[$user->id]=1;
                        break;
                    }

                }

    }

        $users_union= $whomOweItems + $whomOweMoney;


       $users= User::whereIn('id',array_keys($users_union) )->get();
return $users;

    }




public function getItemDebtWittUser( Group $group ,User $user ){



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
        if($user->is(auth()->user())  ) return 0;
        $payments_recived = $this->payments_recived()->where('group_id',$group->id)->where('user_1_id', $user->id) ->where('item', null)->sum('amount');
        $payments_executed = $this->payments_executed()->where('group_id',$group->id)->where('user_2_id', $user->id) ->where('item', null)->sum('amount');
        $user_contribution = DB::table('expenses_user')
            ->where('expenses_user.user_id', $user->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->join('expenses', 'expenses_histories.expense_id',
                '=', 'expenses.id')->where('expenses.group_id',$group->id)
            ->where('expenses_histories.action', '!=', 3)
            ->where('expenses_histories.isLatest', true)
            ->where('expenses.user_id', $this->id)
            ->where('item', null)
            ->sum('user_contribution');
        $my_contribution = DB::table('expenses_user')
            ->where('expenses_user.user_id',$this->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->join('expenses', 'expenses_histories.expense_id',
                '=', 'expenses.id')->where('expenses.group_id',$group->id)
            ->where('expenses.user_id', $user->id)
            ->where('expenses_histories.action', '!=', 3)
            ->where('expenses_histories.isLatest', true)
            ->where('item', null)
            ->sum('user_contribution');
        return($user_contribution - $my_contribution -$payments_recived + $payments_executed);
    }

    public function getItemBalanceWithUser(User $user, Group $group){
        if($user->is(auth()->user())  ) return [];
        $user_contribution = DB::table('expenses_user')
            ->where('expenses_user.user_id', $user->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->join('expenses', 'expenses_histories.expense_id',
                '=', 'expenses.id')->where('expenses.group_id',$group->id)
            ->where('expenses.user_id', $this->id)
            ->where('expenses_histories.action', '!=', 3)
            ->where('expenses_histories.isLatest', true)
            ->where('item','!=', null)
            ->select('expenses_histories.item', 'expenses_user.user_contribution','expenses_histories.amount')
            ->groupBy('item')->selectRaw(' item,  sum(user_contribution) as user_contribution ')
            ->pluck('user_contribution', 'item')->toArray();

        $my_contribution = DB::table('expenses_user')
            ->where('expenses_user.user_id', $this->id)
            ->join('expenses_histories', 'expenses_user.expenses_history_id',
                '=', 'expenses_histories.id')
            ->join('expenses', 'expenses_histories.expense_id',
                '=', 'expenses.id')->where('expenses.group_id',$group->id)
            ->where('expenses.user_id', $user->id)
            ->where('expenses_histories.action', '!=', 3)
            ->where('expenses_histories.isLatest', true)
            ->where('item','!=', null)
            ->select('expenses_histories.item', 'expenses_user.user_contribution','expenses_histories.amount')
            ->groupBy('item')->selectRaw(' item, sum(user_contribution) as user_contribution')
            ->pluck('user_contribution', 'item')->toArray();

        $payments_recived = $this->payments_recived()->where('item','!=',null)
            ->where('group_id', $group->id)
            ->where('user_1_id',$user->id)->groupBy('item')->selectRaw(' item,  sum(amount) as amount ')
            ->pluck('amount', 'item')->toArray();
        $payments_executed = $this->payments_executed()->where('item','!=',null)
            ->where('group_id',$group->id)
            ->where('user_2_id',$user->id) ->groupBy('item')->selectRaw(' item,  sum(amount) as amount ')
            ->pluck('amount', 'item')->toArray();

        $sums = array();
        foreach (array_keys($user_contribution + $my_contribution + $payments_recived + $payments_executed) as $key) {
            $sums[$key] = @($user_contribution[$key] - $my_contribution[$key] - $payments_recived[$key] + $payments_executed[$key]);
        }

        return($sums);

    }

    public function getItemBalance()
    {

        $contribution = DB::table('expenses_user')
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
            ->pluck('balance', 'item')->toArray();

        $payments_recived = $this->payments_recived()->where('item','!=',null)->groupBy('item')->selectRaw(' item,  sum(amount) as amount ')->pluck('amount', 'item')->toArray();
        $payments_executed = $this->payments_executed()->where('item','!=',null)->groupBy('item')->selectRaw(' item,  sum(amount) as amount ')->pluck('amount', 'item')->toArray();

        return($this->combineArrays($contribution, $payments_executed, $payments_recived));

    }

    public function getGroupItemBalance($group){

        $contribution = DB::table('expenses_user')
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
            ->pluck('balance', 'item')->toArray();

        $payments_recived = $this->payments_recived()
                ->where('item','!=',null)
                ->where('group_id', $group->id)->groupBy('item')->selectRaw(' item,  sum(amount) as amount ')
                ->pluck('amount', 'item')->toArray();
        $payments_executed = $this->payments_executed()
            ->where('item','!=',null)
            ->where('group_id', $group->id)->groupBy('item')->selectRaw(' item,  sum(amount) as amount ')
            ->pluck('amount', 'item')->toArray();


        return($this->combineArrays($contribution, $payments_executed, $payments_recived));

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
