<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
  protected $fillable = ['ipaddress', 'lat', 'lng', 'device_id'];

  public function device()
  {
    return $this->belongsTo(Device::class);
  }
}
