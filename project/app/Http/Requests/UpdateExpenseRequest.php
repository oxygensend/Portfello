<?php

namespace App\Http\Requests;

use App\Rules\SelectedUsers;
use App\Rules\SelectedUsersAuthor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'selected_users' => ['required', new SelectedUsers() , new SelectedUsersAuthor()] ,
            'item' => 'nullable',
            'how_much' => 'required | numeric|min:0.1',
        ];
    }
}
