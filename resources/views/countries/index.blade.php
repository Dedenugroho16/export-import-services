@extends('layouts.layout')
@section('title', 'Negara')

@section('content')
<div class="page-body">
    <div class="container-xl mb-5">
        <!-- Countries Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body">
                       <!-- Table Starts Here -->
                        <div class="table-responsive">
                            <table id="countryTable" class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Negara</th>
                                        <th class="text-center">Kode Negara</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data loaded via DataTables -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Table ends here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#countryTable').DataTable({
            processing: false,
            serverSide: true,
            ajax: "{{ route('countries.index') }}",
            columns: [
                { data: 'name', name: 'name', class: 'text-center' },
                { data: 'code', name: 'code', class: 'text-center' }
            ],
            language: {
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                search: "Cari :",
                infoFiltered: "(disaring dari total _MAX_ entri)"
            },
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,

            drawCallback: function() {                              
                $('#countryTable td:nth-child(1), #countryTable th:nth-child(1), #countryTable td:nth-child(2), #countryTable th:nth-child(2)').css({
                    'width': '50%',
                   });
                $('#countryTable td:nth-child(3), #countryTable th:nth-child(3)').css({
                    'width': '5%', 
                   });

            }
        });
    });
</script>

@endsection
