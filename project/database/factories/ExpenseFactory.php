<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if(rand()%2)
            $item = "obiad";
        else
            $item = null;
        return [
            'group_id' => 1,
            'amount' => 12,
            'item' => $item,
            'title'=>'pIZZA TOPIA',
        ];
    }
}
