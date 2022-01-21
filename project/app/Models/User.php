<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
    public function expenses()
    {
        return $this->belongsToMany(
            Expense::class,
            'expenses_user',
            'user_id',
            'expenses_id'
        );
    }

    public function invites(){

        return $this->hasMany(Invites::class);
    }

    public function isIncluded(ExpensesHistory $expense_history){

//        return $this->getUserContribution == 0;
//    TODO
    return true;
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
