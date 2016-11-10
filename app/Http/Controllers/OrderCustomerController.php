<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderCollectRequest;

use Omnipay\Omnipay;
use App\Customer;
use App\Order;
use Auth;
use DB;


class OrderCustomerController extends Controller
{

	private $acceptedFields = [
		'product',
		'variation_id',
		'comment',
		'variation_density',
		'variation_thickness',
		'address1'
	];

	public function index()
	{

		$orders = Order::with('spec', 'product', 'variation', 'address')->where('customer_id', Auth::guard('customer')->user()->id)->latest()->paginate(10);

    return view('customer.orders-list')
        ->withOrders($orders);

	}

	public function credentials()
	{
		return view('customer.credentials')->generate();
	}

	public function collect(OrderCollectRequest $request)
	{

		// $this->validate($request, [
		// 	'order.product' => 'sometimes|required|numeric',
		// 	'order.variation_id' => 'sometimes|required|numeric',
		// 	'order.variation_thickness' => 'sometimes|required|numeric',
		// 	'order.variation_density' => 'sometimes|required|numeric',
		// 	'order.address1' => 'sometimes|required',
		// ]);
	 	
		foreach ($request->all() as $k => $v) {
			if(!in_array($k, $this->acceptedFields)) continue;

			$request->session()->put('order.' . $k, $v);
		}

		dump($request->session()->all());

		return [
			'result' => 'success',
		];

	}

	public function checkout(Request $request, Order $order)
	{
	
			$orderParams = array( 
				'RETURNURL' => url('/my/orders/checkout/'.$order->id.'/success'),
				'CANCELURL' => url('/'),
			  'amount' => 19.96,
			  'description' => 'Payment for order #' . $order->id
			);

			$gateway = Omnipay::create('PayPal_Express'); 

			$gateway->setUsername('andrey.lubinov-facilitator_api1.gmail.com');
	    $gateway->setPassword('DBEKSC7BKR3X592X'); // here will be the password for the account
	    $gateway->setSignature('AFcWxV21C7fd0v3bYYYRCpSSRl31Az70SKllswW3xyaw0Gz68e2ENll3'); // and the signature for the account 
	    $gateway->setTestMode(true); 

			$response = $gateway->purchase($orderParams)->send(); // here you send details to PayPal

			if ($response->isRedirect()) { 
			    $response->redirect(); 
			 } 
			 else { 
			    // payment failed: display message to customer 
			    echo $response->getMessage();
			} 

	}

	public function checkoutSuccess(Request $request, Order $order)
	{
			$orderParams = array( 
				'RETURNURL' => url('/my/orders/checkout/'.$order->id.'/success'),
				'CANCELURL' => url('/'),
			  'amount' => 19.96,
			  'description' => 'Payment for order #' . $order->id
			);

			$gateway = Omnipay::create('PayPal_Express'); 

			$gateway->setUsername('andrey.lubinov-facilitator_api1.gmail.com');
	    $gateway->setPassword('DBEKSC7BKR3X592X'); // here will be the password for the account
	    $gateway->setSignature('AFcWxV21C7fd0v3bYYYRCpSSRl31Az70SKllswW3xyaw0Gz68e2ENll3'); // and the signature for the account 
	    $gateway->setTestMode(true); 

			$response = $gateway->completePurchase($orderParams)->send(); 
      $paypalResponse = $response->getData(); // this is the raw response object 

      if(isset($paypalResponse['ACK']) && $paypalResponse['ACK'] === 'Success') {
      	$order->update([
      		'purchased' => 1,
      		'paypal_payer_id' => $request->PayerID
      	]);
      } 
      else if (isset($paypalResponse['ACK']) && $paypalResponse['ACK'] === 'Failure' && $paypalResponse['L_ERRORCODE0'] == '10486') { 
				return redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$request->token);
      }

    	return view('customer.order-checkout')
    		->withData($paypalResponse);


	}

	public function store(Request $request)
	{
		return DB::transaction(function() use ($request) {

			if(Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])){
				$customer = Auth::guard('customer')->user();
			} else {
			  $customer = Customer::findOrCreate($request);
			}

		  $order = Order::store($request->session()->get('order'), $customer);

		  if(Auth::guard('customer')->guest()){
	      Auth::guard('customer')->login($customer);
		  }

		  return ['orderId' => $order->id];
		  
		});
		
	}

	public function getCredentials()
	{
		return view('order.credentials');
	}
}
