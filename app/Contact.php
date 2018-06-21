<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Contact extends Model
{
  protected $guarded = [];

  protected $with = ['phones', 'professions', 'user', 'agency'];
  protected $appends = ['avatarPath'];

  public static function boot() {
    parent::boot();

    static::deleting(function ($contact) {
      if ($contact->avatar)
        Storage::disk('public')->delete($contact->avatar);
      $contact->user()->delete();
      $contact->phones()->delete();
    });
  }


  public function user() {
    return $this->belongsTo('App\User');
  }

  public function agency() {
    return $this->belongsTo('App\Agency');
  }

  public function professions() {
    return $this->belongsToMany('App\Profession');
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

  public function setProfessions($professions) {
    $this->professions()->sync($professions);
    return $this;
  }

  public function getAvatarPathAttribute() {
    if (!$this->avatar)
      return null;
    return '/storage/'.$this->avatar;
  }
}
