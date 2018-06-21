<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class ContactController extends Controller
{
  public function __construct() {
    $this->middleware('auth:api');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $this->authorize('view', new Contact);
    $filter = $request->filter;
    if (!$filter)
      return Contact::all();

    $result = Contact::whereHas('user', function ($query) use ($filter) {
      $query->where('first_name', 'like', "%$filter%")
        ->orWhere('last_name', 'like', "%$filter%")
        ->orWhere('email', 'like', "%$filter%");
    })
      ->orWhereHas('phones', function ($query) use ($filter) {
        $query->where('number', 'like', "%$filter%");
      })
      ->get();
    return $result;
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->authorize('create', new Contact);

    $contact = json_decode($request->contact, true);

    Validator::make($request->only('avatar'), [
      'avatar' => 'image|nullable'
    ])->validate();


    Validator::make($contact, [
      'agency_id' => 'required|exists:agencies,id',
      'first_name' => 'required',
      'last_name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required',
      'phones' => 'array',
      'professions' => 'array'
    ])->validate();

    $avatar_path = null;
    if ($request->hasFile('avatar'))
      $avatar_path = $request->file('avatar')->store('avatars', 'public');


    $user = User::create([
      'first_name' => $contact['first_name'],
      'last_name' => $contact['last_name'],
      'password' => bcrypt($contact['password']),
      'email' => $contact['email'],
    ]);

    $contact = Contact::create([
      'user_id' => $user->id,
      'agency_id' => $contact['agency_id'],
      'web' => $contact['web'],
      'avatar' => $avatar_path
    ])
    ->setPhones($contact['phones'])
    ->setProfessions($contact['professions']);

    return $contact;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Contact  $contact
   * @return \Illuminate\Http\Response
   */
  public function show(Contact $contact)
  {
    $this->authorize('view', $contact);
    return $contact;
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Contact  $contact
   * @return \Illuminate\Http\Response
   */
  public function edit(Contact $contact)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Contact  $contact
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Contact $contact)
  {
    $this->authorize('update', $contact);
    $data = json_decode($request->contact, true);

    Validator::make($request->only('avatar'), [
      'avatar' => 'image|nullable'
    ])->validate();


    Validator::make($data, [
      'agency_id' => 'required|exists:agencies,id',
      'first_name' => 'required',
      'last_name' => 'required',
      'email' => 'required|email|unique:users,id,'.$contact->user->id,
      'password' => 'required',
      'phones' => 'array',
      'professions' => 'array'
    ])->validate();

    $avatar_path = null;
    if ($request->hasFile('avatar'))
      $avatar_path = $request->file('avatar')->store('avatars', 'public');

    $contact->user()->update([
      'first_name' => $data['first_name'],
      'last_name' => $data['last_name'],
      'password' => bcrypt($data['password']),
      'email' => $data['email'],
    ]);

    $contact->update([
      'agency_id' => $data['agency_id'],
      'web' => $data['web'],
    ]);

    if ($avatar_path)
      $contact->update(['avatar' => $avatar_path]);

    $contact->setPhones($data['phones'])
    ->setProfessions($data['professions']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Contact  $contact
   * @return \Illuminate\Http\Response
   */
  public function destroy(Contact $contact)
  {
    $this->authorize('delete', $contact);
    $contact->delete();
  }
}
