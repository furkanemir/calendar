<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=['furkan','emir','ayşe','aysu','fatma'];
        foreach ($users as $user){
            DB::table('user_lists')->insert([
                'name'=>$user,
            ]);
        }
    }
}
