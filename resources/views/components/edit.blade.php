<x-layout>
    <!-- Page Heading -->
    <div class="header-wrapper mb-3">
        <div>
            <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
            <p class="mb-2">{{ $description }}</p>
            <div class="header-info">
                <div class="w-100">{{ $entity->{$displayFields[0]['name']} }}</div>
                <div class="dates column">
                    <p>Atualizado em: <span>{{ $entity->updated_at ?? "Original" }}</span></p>
                    <p>Criado em: <span>{{ $entity->created_at ?? "Original" }}</span></p>
                </div>
            </div>
        </div>
        <aside class="column ml-3">
            <x-back-button url="{{ $url }}" />
            <x-trash-button id="{{ $id }}" name="{{ $name }}" apiUrl="{{ $apiUrl }}" jwt="{{ $jwt }}" />
        </aside>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row col-sm-12">
                <form action="" method="post" class="w-100">
                    <fieldset class="position-relative">
                        @csrf
                        @method('PUT')

                        @foreach ($displayFields as $field)
                        <div class="form-input field mt-2">
                            <input type="{{ $field['inputType'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ $entity->{$field['name']} }}">
                            <label for="{{ $field['name'] }}" data-title="{{ $field['tooltip'] }}"></label>
                        </div>
                        @endforeach
                    </fieldset>
                    <x-save-button />
                </form>
            </div>
        </div>
    </div>
</x-layout>