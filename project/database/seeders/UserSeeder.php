<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::factory()->create();
        $user=User::factory()->create([
            'name' => 'test2',
            'email' => 'test2@test.com'
        ]);
        $user=User::factory()->create([
            'name' => 'Szymon Berdzik',
            'email' => 'test5@test.com'
        ]);
        $user=User::factory()->create([
            'name' => 'Daniel Definski',
            'email' => 'test3@test.com'
        ]);
        $user=User::factory()->create([
            'name' => 'Jakub Machalica',
            'email' => 'test4@test.com'
        ]);


    }
}
