<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
	public function product()
	{
		return $this->belongsTo('App\Product');
	}

	public function specs()
	{
		return $this->hasMany('App\Spec');
	}

	public function orders()
	{
		return $this->hasMany('App\Order');
	}
}
