<x-layout>
    <!-- Page Heading -->
    <div class="header-wrapper mb-3">
        <div class="w-100">
            <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
            <p class="mb-2">{{ $description }}</p>
            <div class="header-info">
                <div class="w-100 entry-name">{{ $entity->{$displayFields[1]['name']} }}</div>
                <div class="dates column">
                    <p>Atualizado em: <span>{{ $entity->updated_at ?? "Original" }}</span></p>
                    <p>Criado em: <span>{{ $entity->created_at ?? "Original" }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row col-sm-12">
                <form name="update" action="{{ $url }}" method="post" class="w-100" update-form>
                    <fieldset class="position-relative">
                        @csrf

                        @foreach ($displayFields as $field)
                            @switch ($field['inputType'])
                            @case ('text')
                                <x-forms.text name="{{ $field['name'] }}" caption="{{ $field['caption'] }}" value="{{ $entity->{$field['name']} }}" bootstrapColSize="{{ $field['bootstrapColSize'] ?? 12 }}" />
                                @break
                            @case ('select')
                                <x-forms.select name="{{ $field['name'] }}" id="{{ $field['id'] }}" caption="{{ $field['caption'] }}" :options="$field['options']" value="{{ $field['value'] }}" selected="{{ $field['selected'] }}" bootstrapColSize="{{ $field['bootstrapColSize'] ?? 12 }}" />
                                @break
                            @case ('checkbox')
                                <x-forms.checkbox name="{{ $field['name'] }}" caption="{{ $field['caption'] }}" selected="{{ $field['selected'] }}" bootstrapColSize="{{ $field['bootstrapColSize'] ?? 12 }}" />
                                @break
                            @endswitch
                        @endforeach
                    </fieldset>
                    
                    <div class="mx-auto w-100">
                        <div id="chpassword_button_wrapper" class="mt-3 mx-auto">
                            <a href="{{ route('changePassword') }}" class="btn btn-warning btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-key"></i>
                                </span>
                                <span class="text">Alterar senha</span>
                            </a>
                        </div>

                        <x-buttons.update :params="['id' => $id, 'apiUrl' => $apiUrl, 'url' => $url, 'jwt' => $jwt]" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>