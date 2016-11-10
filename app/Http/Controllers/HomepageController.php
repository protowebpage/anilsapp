<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomepageController extends Controller
{
	public function index()
	{
		return view('homepage')
			->withProducts(Product::with('variations')->get());
	}
}
