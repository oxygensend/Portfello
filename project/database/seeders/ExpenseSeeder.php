<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group=DB::table('groups')->first();
        $user=DB::table('users')->first();
        $expense=Expense::factory()->create([
            'group_id' => $group->id,
            'user_id'=>$user->id,
            'amount' => 12,
        ]);
        DB::table('expenses_user')->insert([
            [
                'user_contribution'=>0,
                'user_id'=>$user->id+1,
                'expenses_id' => $expense->id,
            ],
        ]);
        $expense=Expense::factory()->create([
            'user_id'=>$user->id+1,
            'group_id' => $group->id,
            'amount' => 17,
        ]);
        DB::table('expenses_user')->insert([
            [
                'user_contribution'=>0,
                'user_id'=>$user->id,
                'expenses_id' => $expense->id,
            ],
        ]);
        //inna grupa
        $expense=Expense::factory()->create([
            'user_id'=>$user->id+2,
            'group_id' => $group->id,
            'amount' => 19,
        ]);
        DB::table('expenses_user')->insert([
            [
                'user_id'=>$user->id,
                'user_contribution'=>0,
                'expenses_id' => $expense->id,
            ],
        ]);
    }
}
