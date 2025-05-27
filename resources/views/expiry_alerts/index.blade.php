@extends('layouts.master')

@section('content')
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Products Near Expiry</h3>
    </div>
    <div class="box-body">
        @if($products->isEmpty())
            <p>No products expiring soon.</p>
        @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->nama }}</td>
                    <td>{{ $product->qty }}</td>
                    <td>{{ $product->expiry_date->format('Y-m-d') }}</td>
                    <td>
                        @if($product->expiry_date->isToday())
                            <span class="label label-danger">Expires Today</span>
                        @elseif($product->expiry_date->isTomorrow())
                            <span class="label label-warning">Expires Tomorrow</span>
                        @else
                            <span class="label label-info">Expiring Soon</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
