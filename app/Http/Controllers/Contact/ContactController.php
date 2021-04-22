<?php

namespace App\Http\Controllers\Contact;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
  public function add()
  {
     $contacts = Contact::orderBy('name','asc')->get();
     return view('layouts.contact.add',compact('contacts'));
     
  }

}
