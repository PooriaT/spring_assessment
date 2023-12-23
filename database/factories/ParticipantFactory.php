<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(18, 60),
            'points' => 0,
            'address' => $this->faker->address(),
        ];
    }
}


// // database/factories/ParticipantFactory.php

// use Faker\Generator as Faker;

// $factory->define(App\Models\Participant::class, function (Faker $faker) {
//     return [
//         'name' => $faker->name,
//         'age' => $faker->numberBetween(18, 60),
//         'points' => 0,
//         'address' => $faker->address,
//     ];
// });
