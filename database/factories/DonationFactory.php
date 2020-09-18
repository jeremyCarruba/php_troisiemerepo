<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DonationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Donation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount'=> $this->faker->numberBetween($min = 1000, $max = 9000),
            'date' => $this->faker->dateTime($max = 'now', $timezone = null),
            'user_id' => User::factory(),
            'project_id' => Project::factory()
        ];
    }
}
