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
            'email' => function ($callback) { //콜백함수. 메소드 return값인 배열 안에서 생성된 배열 한 행을 가져온다.
                return User::where('name', $callback)->value('email');
                // dd($dd);
            },
            'title' => function ($callback) {
                // return $dd['name'];
                return $callback['name'] . "님이 쓴 글 제목/" . $this->faker->regexify('[A-Za_z0-9._%+-]{3,15}');
                // dd($callback);
            },
            'content' => function ($callback) {
                return $callback['name'] . "님이 쓴 글 내용/" . $this->faker->sentence(50) . $this->faker->regexify('[A-Za_z0-9._%+-]{3,12}');
            },
            'notice_flag' => 'N',
            // 'file_name' => $this->faker->sentence(15),
            // 'file_path' => $this->faker->sentence(15),

        ];
    }
}
