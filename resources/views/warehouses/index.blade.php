@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Warehouses</h1>

    <a href="{{ route('warehouses.create') }}" class="btn btn-primary mb-3">Add New Warehouse</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($warehouses->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($warehouses as $warehouse)
                    <tr>
                        <td>{{ $warehouse->id }}</td>
                        <td>{{ $warehouse->name }}</td>
                        <td>{{ $warehouse->location }}</td>
                        <td>
                            <a href="{{ route('warehouses.show', $warehouse->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No warehouses found.</p>
    @endif
</div>
@endsection
