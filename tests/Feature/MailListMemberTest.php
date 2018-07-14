<?php

namespace Tests\Feature;

use App\MailList;
use App\MailListMember;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailListMemberTest extends TestCase
{
    public function testMailListsCascadeDeletionAreDeletedCorrectly()
    {
        $mailListNew = factory(MailList::class)->create([
          'name' => 'New MailList',
        ]);
        $mailListMemberNew = factory(MailListMember::class)->create([
          'mail_list_id' => $mailListNew->id,
          'email' => 'test@gmail.com',
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('DELETE', '/api/mail_lists/' . $mailListNew->id, [], $headers)
          ->assertStatus(204);

        // TODO: assert exists $mailListMemberNew->id here (by api request)
    }
}
