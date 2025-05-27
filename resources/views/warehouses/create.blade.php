@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Add New Warehouse</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('warehouses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Warehouse Name</label>
            <input type="text" name="name" class="form-control" placeholder="Warehouse Name" required>
        </div>

        <div class="form-group">
            <label for="location">Warehouse Location</label>
            <input type="text" name="location" class="form-control" placeholder="Location" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Warehouse</button>
    </form>
</div>
@endsection
