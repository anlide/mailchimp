<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCascadeDeleteForMailList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_list_members', function (Blueprint $table) {
            $table->integer('mail_list_id')->unsigned()->change();
            $table->foreign('mail_list_id')
              ->references('id')->on('mail_lists')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_list_members', function (Blueprint $table) {
            $table->integer('mail_list_id')->change();
            $table->dropForeign('mail_list_members_mail_list_id_foreign');
        });
        if (env('APP_ENV') != 'testing') {
            Schema::table('mail_list_members', function (Blueprint $table) {
                $table->dropIndex('mail_list_members_mail_list_id_foreign');
            });
        }
    }
}
