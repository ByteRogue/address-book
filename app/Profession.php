<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
  public function contacts() {
    return $this->belongsToMany('App\Contact');
  }
}
