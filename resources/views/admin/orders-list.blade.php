@extends('layouts.backend')

@section('content')

<table class="table table-striped" data-route="admin/orders">
  <thead>
  	<tr>
  		<td>#</td>
      <td>Date</td>
  		<td>Purchased</td>
      <td>Product</td>
  		<td>Customer</td>
  		<td>Variation</td>
  		<td>Thickness</td>
  		<td>Density</td>
  		<td>File</td>
  		<td>Comment</td>
  		<td>Address</td>
      <td class="edit"></td>
      <td class="delete"></td>
  	</tr>
  </thead>
  <tbody>
  	@foreach ($orders as $order)
      @include('admin.orders-list-item')
  	@endforeach
  </tbody>
</table>

<div class="container">
  {{ $orders->links() }}
</div>


@endsection