<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class CustomerController extends Controller
{
	public function index()
	{
		//
	}

	public function credentials()
	{
		return view('customer.profile-links')->render();
	}
}
