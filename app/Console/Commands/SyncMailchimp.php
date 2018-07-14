<?php

namespace App\Console\Commands;

use App\MailList;
use App\MailListMember;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

        $mailchimp = app('Mailchimp');

        // Receive list of maillists.
        $lists = $mailchimp->lists->getList();

        // Store each maillist.
        foreach ($lists['data'] as $list) {
            $name = $list['name'];
            $listId = $list['id'];
            $mailList = MailList::create(['name' => $name]);

            // Receive list of members.
            $members = $mailchimp->lists->members($listId);

            // Store each member, with relation to maillist.
            foreach ($members['data'] as $member) {
                $email = $member['email'];
                $mailList = MailListMember::create(['email' => $email, 'mail_list_id' => $mailList->id]);
            }
        }
    }
}
