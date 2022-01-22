<div class="form-input field my-4">
    <input list="{{ $name . 's' }}" name="{{ $name }}" id="{{ $name }}" value="Feminino">
    <datalist id="{{ $name . 's' }}">
        @foreach ($options as $option)
        <option data-id="{{ $option['id'] }}" name="{{ $option['genero'] }}" value="{{ $option['genero'] }}">
        @endforeach
    </datalist>
    <label for="{{ $name }}" data-title="{{ $caption }}"></label>
</div>