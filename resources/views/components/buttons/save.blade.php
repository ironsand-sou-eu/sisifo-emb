<div id="save_button_wrapper" class="mt-3 mx-auto">
    <a href="#" class="btn btn-success btn-icon-split w-100">
        <span class="icon text-white-50">
            <i class="fas fa-save"></i>
        </span>
        <span class="text">Salvar</span>
    </a>
</div>

<script type="text/javascript" src="/assets/js/create.js"></script>
<script type="text/javascript">
    const saveBtn = document.querySelector('#save_button_wrapper')
    const form = document.querySelector('[update-form]')
    
    saveBtn.addEventListener('click', e => {
        e.preventDefault
        let params = {
            e: e,
            apiUrl: "{{ $params['apiUrl'] }}",
            url: "{{ $params['url'] }}",
            jwt: "{{ $params['jwt'] }}",
        }
        apiCreate(params)
    })
</script>