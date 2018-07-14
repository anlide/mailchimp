<?php

use Illuminate\Database\Seeder;
use App\MailList;
use App\MailListMember;

class MailListMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cleanup table for seed data.
        MailListMember::truncate();

        $faker = \Faker\Factory::create();

        // Create members related to exists mail lists.
        $mailLists = MailList::all('id');
        for ($i = 0; $i < 50; $i++) {
            MailListMember::create([
              'mail_list_id' => $mailLists->random()->id,
              'email' => $faker->email,
            ]);
        }
    }
}
