<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        DB::table('users')->insert([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'email_verified_at'=>now(),
            'gender'=>'male',
            'phone'=>'01011112222',
            'role_id'=>2,
            'password'=>\Hash::make('1111'),
        ]);
        User::factory(50)->create();
    }
}
