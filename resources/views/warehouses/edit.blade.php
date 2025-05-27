@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Edit Warehouse</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Warehouse Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $warehouse->name) }}" required>
        </div>

        <div class="form-group">
            <label for="location">Warehouse Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $warehouse->location) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Warehouse</button>
        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
