<x-layout>
    <!-- Page Heading -->
    <div class="header-wrapper mb-3">
        <div class="w-100">
            <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
            <p class="mb-2">{{ $description }}</p>
        </div>
        <aside class="column ml-3">
            <x-buttons.back url="{{ $url }}" />
        </aside>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row col-sm-12">
                <form name="new" action="{{ $url }}" method="post" class="w-100" create-form>
                    <fieldset class="position-relative">
                        @csrf

                        @foreach ($displayFields as $field)
                            @switch ($field['inputType'])
                            @case ('text')
                                <x-forms.text name="{{ $field['name'] }}" caption="{{ $field['caption'] }}" />
                                @break
                            @case ('select')
                                <x-forms.select name="{{ $field['name'] }}" caption="{{ $field['caption'] }}" :options="$field['options']" id="{{ $field['id'] }}" value="{{ $field['value'] }}" />
                                @break
                            @endswitch
                        @endforeach
                    </fieldset>
                    <x-buttons.save :params="['apiUrl' => $apiUrl, 'url' => $url, 'jwt' => $jwt]" />
                </form>
            </div>
        </div>
    </div>
</x-layout>