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
                            <table class="display dataTable dtr-inline" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        @foreach ($tableColumnNames as $tableColumnName)
                                        <th @class(["sorting", "sorting_asc" => $loop->first]) tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">{{ $tableColumnName }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        @foreach ($tableColumnNames as $tableColumnName)
                                        <th rowspan="1" colspan="1">{{ $tableColumnName }}</th>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/assets/js/delete.js"></script>
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
                ],
                "language": {
                    url: 'http://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json'
                }
            })
        })
    </script>
</x-layout>