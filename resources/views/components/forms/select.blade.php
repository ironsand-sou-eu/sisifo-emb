<div class="form-input field my-4 mx-2 col-lg-{{ $bootstrapColSize }}">
    <input list="{{ $name . 's' }}" name="{{ $name }}" id="{{ $name }}" value="{{ $selected ?? '' }}">
    <label for="{{ $name }}" data-title="{{ $caption }}"></label>
    <datalist id="{{ $name . 's' }}">
        @foreach ($options as $option)
        <option data-id='{{ $option[$id] }}' name='{{ $option[$value] }}' value='{{ $option[$value] }}'>
        @endforeach
    </datalist>
</div>