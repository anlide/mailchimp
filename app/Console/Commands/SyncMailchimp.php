<?php

namespace App\Console\Commands;

use App\MailList;
use App\MailListMember;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mailchimp\Mailchimp;

class SyncMailchimp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailchimp:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync mailchimp data to our database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Cleanup database before sync.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MailList::truncate();
        MailListMember::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $mc = new Mailchimp(env('MAILCHIMP_API_KEY'));

        // Receive list of maillists.
        // TODO: implement pagination if needs
        $result = $mc->get('lists');

        // Store each maillist.
        foreach ($result['lists'] as $list) {
            $name = $list->name;
            $listId = $list->id;
            $mailList = MailList::create(['name' => $name, 'list_id' => $listId]);

            // Receive list of members.
            // TODO: implement pagination if needs
            $resultMembers = $mc->get('lists/' . $listId . '/members');

            // Store each member, with relation to maillist.
            foreach ($resultMembers['members'] as $member) {
                $email = $member->email_address;
                $first_name = $member->merge_fields->FNAME;
                $last_name = $member->merge_fields->LNAME;
                MailListMember::create([
                  'email' => $email,
                  'first_name' => $first_name,
                  'last_name' => $last_name,
                  'mail_list_id' => $mailList->id
                ]);
            }
        }
    }
}
