<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(
            Trop::class,
            'group_user',
            'group_id',
            'user_id'
        );
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
