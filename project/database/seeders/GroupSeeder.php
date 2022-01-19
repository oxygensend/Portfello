<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Group::factory(8)->create([
            'user_id' => 1
        ]);
        $user=DB::table('users')->first();
        $group=DB::table('groups')->first();
        DB::table('group_user')->insert([
            [
                'user_id'=>$user->id,
                'group_id'=>$group->id,
            ],
        ]);
        DB::table('group_user')->insert([
            [
                'user_id'=>$user->id+1,
                'group_id'=>$group->id,
            ],
        ]);
        DB::table('group_user')->insert([
            [
                'user_id'=>$user->id+2,
                'group_id'=>$group->id,
            ],
        ]);


    }
}
