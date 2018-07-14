<?php

namespace Tests\Feature;

use App\MailList;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailListTest extends TestCase
{
    public function testsMailListsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
          'name' => 'Lorem Ipsum',
        ];

        $this->json('POST', '/api/mail_lists', $payload, $headers)
          ->assertStatus(201)
          ->assertJson(['name' => 'Lorem Ipsum']);
    }

    public function testsMailListsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $mailList = factory(MailList::class)->create([
          'name' => 'First MailList',
        ]);

        $payload = [
          'name' => 'Lorem Ipsum',
        ];

        $response = $this->json('PUT', '/api/mail_lists/' . $mailList->id, $payload, $headers)
          ->assertStatus(200)
          ->assertJson([
            'name' => 'Lorem Ipsum',
          ]);
    }

    public function testsMailListsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $mailList = factory(MailList::class)->create([
          'name' => 'First MailList',
        ]);

        $this->json('DELETE', '/api/mail_lists/' . $mailList->id, [], $headers)
          ->assertStatus(204);
    }

    public function testMailListsAreListedCorrectly()
    {
        $mailList1 = factory(MailList::class)->create([
          'name' => 'First MailList',
        ]);

        $mailList2 = factory(MailList::class)->create([
          'name' => 'Second MailList',
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/mail_lists', [], $headers)
          ->assertStatus(200)
          ->assertJsonFragment([ 'id' => $mailList1->id, 'name' => 'First MailList' ])
          ->assertJsonFragment([ 'id' => $mailList2->id, 'name' => 'Second MailList' ])
          ->assertJsonStructure([
            '*' => ['id', 'name'],
          ]);
    }
}
