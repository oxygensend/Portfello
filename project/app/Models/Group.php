<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'group_user',
            'group_id',
            'user_id'
        )->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function payments()
    {

        return $this->hasMany(Payment::class);

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

    public function invites()
    {
        return $this->hasMany(Invites::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
