@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Warehouse Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $warehouse->name }}</h5>
            <p class="card-text"><strong>Location:</strong> {{ $warehouse->location }}</p>
            <p class="card-text"><strong>ID:</strong> {{ $warehouse->id }}</p>
            <p class="card-text"><small class="text-muted">Created at: {{ $warehouse->created_at->format('d M Y, h:i A') }}</small></p>
            <p class="card-text"><small class="text-muted">Updated at: {{ $warehouse->updated_at->format('d M Y, h:i A') }}</small></p>
        </div>
    </div>

    <a href="{{ route('warehouses.index') }}" class="btn btn-primary mt-3">Back to List</a>
</div>
@endsection
