<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function expense_histories(){
        return $this->hasMany(ExpensesHistory::class);
    }

//last history
    public function latest_history(){

        return $this->histories()->orderByDesc('created_at')->where('action','!=', '3');

    }


    public function users(){
        return $this->belongsToMany(
            User::class,
            'expenses_user',
            'expenses_id',
            'user_id');
    }


    public function user(){
        return $this->belongsTo(
            User::class);
    }

    public function getMonth(){

        return $this->created_at->format('M') ;

    }

    public function getDay(){

        return $this->created_at->format('j') ;

    }

    public function getDate(){

        return $this->created_at->format('j F Y') ;

    }





}
