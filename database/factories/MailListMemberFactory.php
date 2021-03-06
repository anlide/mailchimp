<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\MailListMember::class, function (Faker $faker) {
  $mailLists = \App\MailList::all('id');
  return [
    'mail_list_id' => $mailLists->random()->id,
    'email' => $faker->email,
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
  ];
});
