<div id="del_button_wrapper" class="float-right clear-right mb-3 w-100">
    <a href="#" class="btn btn-danger btn-icon-split w-100">
        <span class="icon text-white-50">
            <i class="fas fa-trash-alt"></i>
        </span>
        <span class="text">Excluir</span>
    </a>
</div>

<script type="text/javascript" src="/assets/js/delete.js"></script>
<script type="text/javascript">
    const delBtn = document.querySelector('#del_button_wrapper')
    delBtn.onclick = ev => {
        let params = {
            ev: ev,
            id: "{{ $id }}",
            name: "{{ $name }}",
            apiUrl: "{{ $apiUrl }}",
            jwt: "{{ $jwt }}",
            redirect: "{{ $url }}"
        }
        apiDelete(params)
    };
</script>