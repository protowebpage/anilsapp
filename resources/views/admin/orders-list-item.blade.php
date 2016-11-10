<tr data-id="{{ $order->id }}">
	<td>{{ $order->id }}</td>
	<td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
  <td>{{ $order->purchased ? 'Yes' : 'No'}}</td>
  <td>{{ $order->product->name }}</td>
	<td>{{ str_limit($order->customer->email, 10) }}</td>
	<td>{{ $order->variation->name }}</td>
	<td>
		<a href="#" class="editable" data-field="variation_thickness">{{ $order->spec->variation_thickness }}</a>
	</td>
	<td>
		<a href="#" class="editable" data-field="variation_density">{{ $order->spec->variation_density }}</a>		
	</td>
	<td>
		<a href="/storage/uploads/confirmed/{{ $order->file }}">{{ str_limit($order->file, 10) }}</a>
	</td>
	<td>{{ $order->comment }}</td>
	<td>
		<a href="#" class="editable" data-field="address1">{{ $order->address->address1 }}</a>
	</td>
	<td></td>
	<td>
		<a href="#" data-id="{{ $order->id }}" data-route="admin/orders" class="delete-list-item">
			<span class="glyphicon glyphicon-remove-circle"></span>
		</a>
	</td>
</tr>
