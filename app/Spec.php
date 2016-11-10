<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{

	protected $fillable = [
		'order_id',
		'product_id',
		'variation_id',
		'variation_thickness',
		'variation_density'
	];

	public function variation()
	{
		return $this->belongsTo('App\Variation');
	}
	public function product()
	{
		return $this->belongsTo('App\Product');
	}

	public function order()
	{
		return $this->belongsTo('App\Order');
	}
}
