<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SelectedUsersAuthor implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

if(sizeof($value) ==1) {
    $logged_id = $user = auth()->user()->id;
    return intval($value[0]) != $logged_id;

}else{ return true;}

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return      'Select other users, not only you';
    }
}
