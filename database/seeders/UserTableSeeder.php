<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            DB::table('users')->insert([
                'firstName' => $faker->firstName,
                'middleName' => $faker->lastName,
                'lastName' => $faker->lastName,
                'mobile' => $faker->phoneNumber,
                'email' => $faker->unique()->email,
                'passwordHash' => md5($faker->password),
                'registerAt' => $faker->dateTimeBetween('-2 years', 'now'),
                'lastLogin' => $faker->dateTimeBetween('-1 year', 'now'),
                'intro' => $faker->sentence(15),
                'profile' => $faker->text(100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
