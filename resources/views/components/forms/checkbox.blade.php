<div class="form-input field my-4 mx-2 col-lg-{{ $bootstrapColSize }}">
    <input type="checkbox" class="w-auto" name="{{ $name }}" id="{{ $name }}" {{ $selected ? 'checked' : '' }}>
    <label for="{{ $name }}">{{ $name }}</label>
</div>