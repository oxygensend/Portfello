<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function executor(){

        return $this->belongsTo(User::class, 'user_1_id');
    }

    public function recipient(){

        return $this->belongsTo(User::class, 'user_2_id');
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }
}
