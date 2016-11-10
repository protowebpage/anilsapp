<tr data-id="{{ $order->id }}">
	<td>{{ $order->id }}</td>
	<td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
  <td>{{ $order->purchased ? 'Yes' : 'No'}}</td>
	<td>{{ $order->product->name }}</td>
	<td>{{ $order->variation->name }}</td>
	<td>{{ $order->spec->variation_thickness }}</td>
	<td>{{ $order->spec->variation_density }}</td>
	<td>
		<a href="/storage/uploads/confirmed/{{ $order->file }}">{{ str_limit($order->file, 16) }}</a>
	</td>
	<td>{{ $order->comment }}</td>
	<td>{{ $order->address->address1 }}</td>
</tr>

