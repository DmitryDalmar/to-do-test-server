<?php

namespace Database\Factories\Task;

use App\Models\Task\Task;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userCount = User::count();

        return [
            'title' => $this->faker->word . ' ' .  $this->faker->word,
            'description' => $this->faker->text,
            'user_id' => $userCount ? rand(1, $userCount) : null,
        ];
    }
}
