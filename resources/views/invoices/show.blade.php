@extends('template')
@section('content')
<h1>Invoice Details</h1>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>Rp. {{ $item['price'] }}</td>
                <td>Rp. {{ $item['subtotal'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="text-end"><strong>Total:</strong></td>
            <td><strong>Rp. {{ $invoice->total }}</strong></td>
        </tr>
    </tbody>
</table>
@endsection
