<?php

use Illuminate\Database\Seeder;
use App\MailList;

class MailListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cleanup table for seed data.
        MailList::truncate();

        $faker = \Faker\Factory::create();

        // Create lists.
        for ($i = 0; $i < 5; $i++) {
            MailList::create([
              'name' => $faker->sentence,
            ]);
        }
    }
}
