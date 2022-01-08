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

    public function users(){
        return $this->belongsToMany(
            Trop::class,
            'expenses_user',
            'expenses_id',
            'user_id');
    }
}
