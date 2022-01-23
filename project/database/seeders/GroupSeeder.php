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

        Group::factory(2)->create([
            'user_id' => 1
        ]);
        Group::factory(1)->create([
            'user_id' => 2
        ]);

        $user=DB::table('users')->first();
        $group=DB::table('groups')->first();

        // 1 group
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
        DB::table('group_user')->insert([
            [
                'user_id'=>$user->id+3,
                'group_id'=>$group->id,
            ],
        ]);



        // 2 group
        DB::table('group_user')->insert([
            [
                'user_id'=>$user->id,
                'group_id'=>$group->id+1,
            ],
        ]);
        DB::table('group_user')->insert([
            [
                'user_id'=>$user->id+2,
                'group_id'=>$group->id+1,
            ],
        ]);
        DB::table('group_user')->insert([
            [
                'user_id'=>$user->id+3,
                'group_id'=>$group->id+1,
            ],
        ]);


        // 3 group
        DB::table('group_user')->insert([
            [
                'user_id'=>$user->id+1,
                'group_id'=>$group->id+2,
            ],
        ]);
        DB::table('group_user')->insert([
            [
                'user_id'=>$user->id,
                'group_id'=>$group->id+2,
            ],
        ]);
        DB::table('group_user')->insert([
            [
                'user_id'=>$user->id+4,
                'group_id'=>$group->id+2,
            ],
        ]);

    }
}
