<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;

class TestController extends Controller
{
	public function paypal(Request $request)
	{

		// dd(url('/test/paypal/success'));

		$orderParams = array( 
			'RETURNURL' => url('/my/orders/success'),
			'CANCELURL' => url('/'),
		  'amount' => 19.96, 
		);

		$gateway = Omnipay::create('PayPal_Express'); 

		$gateway->setUsername('andrey.lubinov-facilitator-1_api1.gmail.com');
    $gateway->setPassword('D27ZP6B7P5T57ELA'); // here will be the password for the account
    $gateway->setSignature('AFcWxV21C7fd0v3bYYYRCpSSRl31ARaEPDv76EgTfiInljfGqj5leb4S'); // and the signature for the account 
    $gateway->setTestMode(true); 

		$response = $gateway->purchase($orderParams)->send(); // here you send details to PayPal
		// dd($response);

		if ($response->isRedirect()) { 
		    // redirect to offsite payment gateway 
		    $response->redirect(); 
		 } 
		 else { 
		    // payment failed: display message to customer 
		    echo $response->getMessage();
		} 

		dump($gateway);
   // Initialise the gateway
   // $gateway->initialize(...);

	}

	public function paypalCancel(Request $request)
	{
		return 'cancel';
		dump($request->all());
	}

	public function paypalSuccess(Request $request)
	{
		return 'success';
		dump($request->all());
	}

}
