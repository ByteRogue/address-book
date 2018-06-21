<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
  protected $guarded = [];
  public static function boot() {
    parent::boot();

    static::deleting(function ($agency) {
      $agency->contacts->each->delete();
      $agency->phones()->delete();
    });
  }
  public function city() {
    return $this->belongsTo('App\City');
  }

  public function contacts() {
    return $this->hasMany('App\Contact');
  }

  public function phones() {
    return $this->morphMany('App\Phone', 'owner');
  }
  
  public function setPhones($phones) {
    $this->phones()->delete();
    foreach ($phones as $number) {
      $this->phones()->create([
        'number'=>$number
      ]);
    }
    return $this;
  }
}
