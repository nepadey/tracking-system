<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
  protected $fillable = ['device_token', 'user_id', 'name', 'enabled',];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function location()
  {
    return $this->hasMany(Location::class);
  }
}
