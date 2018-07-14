<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MailListMember
 * @property int id
 * @property int mail_list_id
 * @property string created_at
 * @property string updated_at
 * @property string email
 * @package App
 */
class MailListMember extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'email', 'mail_list_id',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'created_at', 'updated_at',
  ];
}
