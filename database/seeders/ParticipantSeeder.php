<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Participant;
use App\Jobs\GenerateQrCode;
use Faker\Factory as Faker;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $name = $faker->name;

            // Generate a QR code and store the filename
            $qrCodeJob = new GenerateQrCode(new Participant());
            $qrCodeJob->handle();
            Participant::create([
                'name' => $name,
                'age' => $faker->numberBetween(18, 65),
                'points' => 0, 
                'address' => $faker->address,
                'qr_code_filename' => "{$name}_qr.png",
            ]);
        }
    }
}
