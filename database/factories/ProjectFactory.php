<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Database\Factories\UserCustomFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'date' => $this->faker->dateTime($max = 'now', $timezone = null),
            'user_id' => User::factory(),
        ];
    }
}
