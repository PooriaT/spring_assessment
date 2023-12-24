<?php

namespace Database\Factories;
use App\Jobs\GenerateQrCode;
use App\Models\Participant;
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
        $name = $this->faker->name;

        return [
            'name' => $name,
            'age' => $this->faker->numberBetween(18, 60),
            'points' => 0,
            'address' => $this->faker->address(),
            'qr_code_filename' => "{$name}_qr.png",
        ];
    }

     /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Participant $participant) {
            // Generate a QR code and store the filename
            $qrCodeJob = new GenerateQrCode($participant);
            $qrCodeJob->handle();
        });
    }
}
