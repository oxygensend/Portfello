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
            'creator'=>$user->id,
        ]);
        $id=1;
        DB::table('expenses_histories')->insert([
            [
                'id'=>$id,
                'expense_id' => $expense->id,
                'action'=>  1,
                'amount' => 10,
                'title' => 'bar',
            ],
        ]);

        DB::table('expenses_user')->insert([
            [
                'user_contribution'=>5,
                'user_id'=>$user->id+1,
                'expenses_history_id' => $id,
            ],
        ]);
        DB::table('expenses_user')->insert([
            [
                'user_contribution'=>5,
                'user_id'=>$user->id+2,
                'expenses_history_id' => $id,
            ],
        ]);
        $expense=Expense::factory()->create([
            'group_id' => $group->id,
            'creator'=>$user->id+1,
        ]);
        $id=2;
        DB::table('expenses_histories')->insert([
            [

                'expense_id' => $expense->id,
                'action'=>  1,
                'amount' => 20,
                'title' => 'pizza',
            ],
        ]);
        DB::table('expenses_user')->insert([
            [
                'user_contribution'=>15,
                'user_id'=>$user->id,
                'expenses_history_id' => $id,
            ],
        ]);
        DB::table('expenses_user')->insert([
            [
                'user_contribution'=>3,
                'user_id'=>$user->id+2,
                'expenses_history_id' => $id,
            ],
        ]);

        $expense=Expense::factory()->create([
            'group_id' => $group->id,
            'creator'=>$user->id+2,
        ]);
        $id=3;
        DB::table('expenses_histories')->insert([
            [

                'expense_id' => $expense->id,
                'action'=>  1,
                'amount' => 50,
                'title' => 'rynek',
            ],
        ]);
        DB::table('expenses_user')->insert([
            [
                'user_contribution'=>20,
                'user_id'=>$user->id,
                'expenses_history_id' => $id,
            ],
        ]);
        DB::table('expenses_user')->insert([
            [
                'user_contribution'=>13,
                'user_id'=>$user->id+1,
                'expenses_history_id' => $id,
            ],
        ]);
        DB::table('expenses_user')->insert([
            [
                'user_contribution'=>9,
                'user_id'=>$user->id+3,
                'expenses_history_id' => $id,
            ],
        ]);
    }
}
