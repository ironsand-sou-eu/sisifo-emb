<div class="form-input field my-4 mx-2 col-lg-{{ $bootstrapColSize }}">
    <input type="text" name="{{ $name }}" id="{{ $name }}" value="{{ $value ?? '' }}">
    <label for="{{ $name }}" data-title="{{ $caption }}"></label>
</div>