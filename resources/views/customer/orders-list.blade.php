@extends('layouts.frontend')

@section('content')

<div class="conatiner">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li class="active">My Orders</li>
  </ol>
</div>


<table class="table table-striped">
  <thead>
  	<tr>
  		<td>#</td>
      <td>Date</td>
  		<td>Purchased</td>
  		<td>Product</td>
  		<td>Variation</td>
  		<td>Thickness</td>
  		<td>Density</td>
  		<td>File</td>
  		<td>Comment</td>
  		<td>Address</td>
  	</tr>
  </thead>
  <tbody>
    @each('customer.orders-list-item', $orders, 'order', 'customer.orders-list-empty')
  </tbody>
</table>

<div class="container">
  {{ $orders->links() }}
</div>


@endsection