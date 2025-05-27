@csrf

<div class="form-group">
    <label for="name">Warehouse Name</label>
    <input type="text" name="name" id="name" value="{{ old('name', $warehouse->name ?? '') }}" class="form-control" required>
    @error('name')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="location">Location</label>
    <input type="text" name="location" id="location" value="{{ old('location', $warehouse->location ?? '') }}" class="form-control" required>
    @error('location')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
