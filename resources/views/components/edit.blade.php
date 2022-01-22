<x-layout>
    <!-- Page Heading -->
    <div class="header-wrapper mb-3">
        <div class="w-100">
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
                <form name="update" action="{{ $url }}" method="post" class="w-100" update-form>
                    <fieldset class="position-relative">
                        @csrf
                        {{-- @method('PUT') --}}

                        @foreach ($displayFields as $field)
                            @switch ($field['inputType'])
                            @case ('text')
                                <x-forms.text name="{{ $field['name'] }}" caption="{{ $field['caption'] }}" value="{{ $entity->{$field['name']} }}" />
                                @break
                            @case ('select')
                                <x-forms.select name="{{ $field['name'] }}" caption="{{ $field['caption'] }}" :options="$field['options']" />
                                @break
                            @endswitch
                        @endforeach
                    </fieldset>
                    <x-save-button :params="['id' => $id, 'apiUrl' => $apiUrl, 'jwt' => $jwt]" />
                </form>
            </div>
        </div>
    </div>
</x-layout>