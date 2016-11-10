<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;


class ProductController extends Controller
{
	public function variations(Product $product)
	{
    return view('products.variations')
        ->withVariations($product->variations);
	}
}
