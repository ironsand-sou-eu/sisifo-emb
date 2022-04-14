<div id="button_wrapper" class="d-flex float-right clear-right mb-3">
    <form action="{{ route('sapReport') }}" id="report-data" class="form-inline dataTables_filter">
        <label for="initialDate" class="mr-2">Data inicial:</label>
        <input type="date" class="w-auto mr-2" name="initialDate" id="initialDate" placeholder="Data inicial">
        <label for="finalDate" class="mr-2">Data final:</label>
        <input type="date" class="w-auto mr-2" name="finalDate" id="finalDate" placeholder="Data final">
    </form>
    <a id="dajes-report" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-file-excel"></i>
        </span>
        <span class="text">Relatório</span>
    </a>
</div>

<script type="text/javascript">
    const reportBtn = document.querySelector('#dajes-report')
    const form = document.querySelector('form#report-data')
    
    reportBtn.addEventListener('click', e => {
        e.preventDefault
        if (form.classList.contains("show"))
            form.submit()
        form.classList.toggle("show")
    })
</script>
