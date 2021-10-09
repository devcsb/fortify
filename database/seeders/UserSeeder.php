<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // DB::table('users')->insert([
        //     'name' => $this->faker->unique()->name(),
        //     'email' => $this->faker->unique()->safeEmail(),
        //     'email_verified_at' => now(),
        //     'gender' => $this->faker->randomElement($array = ['male', 'female']),
        //     'phone' => $this->faker->randomDigit(),
        //     'password' => Str::random(10), // password
        //     'remember_token' => Str::random(10),
        // ]);

        User::factory(50)->create();
    }
}
