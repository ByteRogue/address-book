<?php

namespace App\Http\Controllers;

use App\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $filter = $request->filter;
      if (!$filter)
        return Agency::with('phones')->get();

      return Agency::where('name', 'like', "%$filter%")
        ->orWhere('email', 'like', "%$filter%")
        ->orWhereHas('phones', function ($query) use ($filter) {
          $query->where('number', 'like', "%$filter%");
        })->with('phones')
        ->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', new Agency);
      $request->validate([
        'name' => 'required',
        'address' => 'required',
        'email' => 'required|email|unique:agencies',
        'web' => 'required',
        'city_id' => 'required|exists:cities,id',
        'phones' => 'array'
      ]);

      return Agency::create($request->except('phones'))->setPhones($request->phones);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function show(Agency $agency)
    {
      $this->authorize('view', $agency);
      $agency->load('city.country', 'phones');

      return $agency;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agency $agency)
    {
      $this->authorize('update', $agency);
      $request->validate([
        'name' => 'required',
        'address' => 'required',
        'email' => 'required|email|unique:agencies,id,'.$agency->id,
        'web' => 'required',
        'city_id' => 'required|exists:cities,id',
      ]);

      $agency->update($request->except('phones'));
      $agency->setPhones($request->phones);
      return $agency;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agency $agency)
    {
      $agency->delete();
    }
}
