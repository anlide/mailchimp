<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MailList
 * @property string id
 * @property string created_at
 * @property string updated_at
 * @property string name
 * @package App
 */
class MailList extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
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
