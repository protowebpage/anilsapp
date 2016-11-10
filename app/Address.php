<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $fillable = [
		'address1',
		'customer_id',
	];


	public function orders()
	{
		$this->hasMany('App\Order');
	}

	public function customer()
	{
		$this->belongsTo('App\Customer');
	}
}
