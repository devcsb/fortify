<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Board::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => User::all()->random()->name,
            // 'email' => User::all()->random()->email,
            'email' => function ($name) { //전달받은 변수명 값을 어디서 무엇을 받아오는 것인지?
                // return User::where('name', '=', User::find($board['name']));
                return User::where('name', $name)->value('email');
                // return User::find($board['name']);
            },
            'title' => $this->faker->sentence(),
            'content' => $this->faker->sentence(),
            'file' => $this->faker->sentence(),

        ];
    }
}
