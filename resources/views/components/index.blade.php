<x-layout>
    <!-- Script e CSS da datatables-->
    <link rel="stylesheet" href="http://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="http://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
    <p class="mb-4">{{ $description }}</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <x-new-button />
                            <table class="display dataTable dtr-inline" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        @foreach ($tableColumnNames as $tableColumnName)
                                        <th @class(["sorting", "sorting_asc" => $loop->first]) tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">{{ $tableColumnName }}</th>
                                        @endforeach
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        @foreach ($tableColumnNames as $tableColumnName)
                                        <th rowspan="1" colspan="1">{{ $tableColumnName }}</th>
                                        @endforeach
                                        <th rowspan="1" colspan="1"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        $(document).ready( function () {
            var table = $('#dataTable').DataTable( {
                "ajax": {
                    "url": "{{ $apiUrl }}",
                    "dataSrc": function (json) {
                        for (var i = 0; i < json.fullList.length; i++) {
                            let name = json.fullList[i].{{ $dbNameField }}
                            let id = json.fullList[i].{{ $dbIdField }}
                            json.fullList[i].{{ $dbNameField }} = `<a href="{{ $url }}/${id}">${name}</a>`
                        }
                        return json.fullList
                    },
                    "headers": {
                        "Authorization": "Bearer {{ $jwt }}"
                    }
                },
                "columns": [
                    @foreach ($dbFieldNames as $dbFieldName)
                    { data: "{{ $dbFieldName }}" },
                    @endforeach
                    { data: null }
                ],
                "aoColumnDefs": [{
                    "mData": null,
                    "sDefaultContent": "<a href='#' trash><i class='fas fa-trash'></a>",
                    "aTargets": -1
                }],
                "language": {
                    url: 'http://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json'
                }
            })

            $('#dataTable').on( 'click', 'i', async function (ev) {
                let entityId = table.row( $(this).parents('tr') ).data()['{{ $dbIdField }}'];
                let entityName = table.row( $(this).parents('tr') ).data()['{{ $dbNameField }}'];
                
                if (!window.confirm(`Tem certeza de que deseja excluir o registro "${entityName}"?`)) {
                    return
                }
                ev.preventDefault()

                const options = {
                    method: 'DELETE',
                    headers: { "Authorization": "Bearer {{ $jwt }}" }
                }
                let rssUrl = `{{ $apiUrl }}/${entityId}`
                const flashDiv = document.querySelector("[flash]")
                try {
                    const resp = await fetch(rssUrl, options)
                    const json = await resp.json()
                    
                    if (resp.status >= 400) {
                        throw {resp, json}
                    }

                    flashDiv.innerHTML = json.resp
                    flashDiv.classList.add("success")
                    flashDiv.classList.remove("hidden", "error")
                    table.ajax.reload()

                } catch (err) {
                    switch (err.resp.status) {
                        case 404:
                            errMsg = `Não foi encontrado um registro com o ID ${entityId}`
                            break;
                        default:
                            errMsg = `${err.json.resp}.<br>Detalhes: ${err.json.data.errorInfo}`
                            if (errMsg.includes('a foreign key constraint fails')) {
                                errMsg = `O registro não pôde ser excluído, pois possui outros registros vinculados.`
                            }
                            break;
                    }

                    flashDiv.innerHTML = errMsg
                    flashDiv.classList.add("error")
                    flashDiv.classList.remove("hidden", "success")
                }
            });
        })
    </script>
</x-layout>