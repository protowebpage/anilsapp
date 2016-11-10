@extends('layouts.frontend')

@section('content')

  <div class="container">

    <div class="conatiner">
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ action('OrderCustomerController@index') }}">My Orders</a></li>
        <li class="active">PayPal Checkout</li>
      </ol>
    </div>
      
    @if ($data['ACK'] === 'Success')
      <div class="alert alert-success" role="alert">your order is successfully purchased</div>
    @elseif ($data['ACK'] === 'SuccessWithWarning')
      <div class="alert alert-warning" role="alert">
        <p>{{ $data['L_SHORTMESSAGE0'] }}</p>
        <p>{{ $data['L_LONGMESSAGE0'] }}</p>
      </div>
    @else
      <div class="alert alert-error" role="alert">
        <p>{{ $data['L_SHORTMESSAGE0'] }}</p>
        <p>{{ $data['L_LONGMESSAGE0'] }}</p>    
      </div>
    @endif

    {{-- Paypal Debug info --}}
    <div class="debug">
      {{ dump($data) }}
    </div>

  </div>
@endsection