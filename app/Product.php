<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public function variations()
	{
		return $this->hasMany('App\Variation');
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
