<?php

namespace Tests\Feature;

use App\MailList;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailListTest extends TestCase
{
    public function testsMailListsAreCreatedCorrectly()
    {
        $payload = [
          'name' => 'Lorem Ipsum',
        ];

        $this->json('POST', '/api/mail_lists', $payload)
          ->assertStatus(201)
          ->assertJson(['name' => 'Lorem Ipsum']);
    }

    public function testsMailListsAreUpdatedCorrectly()
    {
        $mailList = factory(MailList::class)->create([
          'name' => 'First MailList',
        ]);

        $payload = [
          'name' => 'Lorem Ipsum',
        ];

        $response = $this->json('PUT', '/api/mail_lists/' . $mailList->id, $payload)
          ->assertStatus(200)
          ->assertJson([
            'name' => 'Lorem Ipsum',
          ]);
    }

    public function testsMailListsAreDeletedCorrectly()
    {
        $mailList = factory(MailList::class)->create([
          'name' => 'First MailList',
        ]);

        $this->json('DELETE', '/api/mail_lists/' . $mailList->id, [])
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

        $response = $this->json('GET', '/api/mail_lists', [])
          ->assertStatus(200)
          ->assertJsonFragment([ 'id' => $mailList1->id, 'name' => 'First MailList' ])
          ->assertJsonFragment([ 'id' => $mailList2->id, 'name' => 'Second MailList' ])
          ->assertJsonStructure([
            '*' => ['id', 'name'],
          ]);
    }
}
