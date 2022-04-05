<x-layout>
    <!-- Page Heading -->
    <div class="header-wrapper mb-3">
        <div class="w-100">
            <h1 class="h3 mb-2 text-gray-800">Trocar senha</h1>
            <p class="mb-2"></p>
            {{-- <div class="header-info">
                <div class="w-100 entry-name">{{ $entity->{$displayFields[1]['name']} }}</div>
            </div> --}}
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row col-sm-12">
                <form name="update" action="{{ route('changePassword') }}" method="post" class="w-100" update-form>
                    <fieldset class="position-relative">
                        @csrf
                        <div class="form-input field my-4 mx-2 col-lg-6">
                            <input type="password" name="current-pwd" id="current-pwd">
                            <label for="current-pwd" data-title="Senha atual"></label>
                        </div>
                        <div class="form-input field my-4 mx-2 col-lg-6">
                            <input type="password" name="new-pwd" id="new-pwd">
                            <label for="new-pwd" data-title="Nova senha"></label>
                        </div>
                        <div class="form-input field my-4 mx-2 col-lg-6">
                            <input type="password" name="pwd-confirmation" id="pwd-confirmation">
                            <label for="pwd-confirmation" data-title="Repita a nova senha"></label>
                        </div>
                    </fieldset>
                    <div id="updt_button_wrapper" class="mt-3 mx-auto">
                        <button type="submit" class="btn btn-success btn-icon-split w-100">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Salvar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/assets/js/change-pwd.js"></script>
</x-layout>