<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Product;
use App\Address;
use App\Variation;
use App\Spec;
use Storage;


class Order extends Model
{

	protected $fillable = [
		'spec_id',
		'customer_id',
		'address_id',
		'product_id',
		'variation_id',
		'file',
		'comment',
		'purchased',
		'paypal_payer_id',
	];

	public static function store($data, $customer)
	{
    $product = Product::find($data['product']);
    $variation = Variation::find($data['variation_id']);


    // ADDRESS
    $address = Address::create([
        'address1' => $data['address1'],
        'customer_id' => $customer->id
    ]);

    // ORDER
    $order = Order::create([
        'comment' => $data['comment'],
        'file' => '',
        'customer_id' => $customer->id,
        'address_id' => $address->id,
        'product_id' => $product->id,
        'variation_id' => $variation->id,
    ]);

    // SPEC
    $spec = Spec::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'variation_id' => $variation->id,
        'variation_density' => $data['variation_density'],
        'variation_thickness' => $data['variation_thickness'],
    ]);

    $newFileName =  $order->id . '_' . time() . '_' . $data['filenameOriginal'];

    Storage::move(
        'uploads/temporary/' . $data['filenameTmp'], 
        'uploads/confirmed/' . $newFileName
    );

    $order->file = $newFileName;
    $order->save();	

    return $order;	
	}


	// RELATIONS
	public function spec()
	{
		return $this->hasOne('App\Spec');
	}
	public function customer()
	{
		return $this->belongsTo('App\Customer');
	}
	public function address()
	{
		return $this->belongsTo('App\Address');
	}
	public function product()
	{
		return $this->belongsTo('App\Product');
	}
	public function variation()
	{
		return $this->belongsTo('App\Variation');
	}
}
