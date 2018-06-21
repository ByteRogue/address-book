<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profession;

class ProfessionController extends Controller
{
  public function index() {
    return Profession::all();
  }
}
