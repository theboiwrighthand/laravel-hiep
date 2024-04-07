<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'id' => $faker->unique()->numberBetween($min = 0, $max = 2147483647),
                'firtName' => $faker->firstName,
                'middleName' => $faker->lastName,
                'lastName' => $faker->lastName,
                'mobile' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'passwordHash' =>  $faker->password(),
                'registerAt' => now(),
                'lastLogin' => now(),
                'intro' => $faker->sentence,
                'profile' => $faker->paragraph,
            ]);
        }
    }
}
