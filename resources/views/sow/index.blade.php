@extends('layouts.master')
@section('content-header')
    <div class="container-fluid">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Scope Of Work</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">home</a></li>
                    <li class="breadcrumb-item active">Scope Of Work</li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@includeIf('sow.form')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <button onclick="addForm()" class="btn btn-success btn-xs btn-flat"><i
                                    class="fa fa-plus-circle"></i>
                                Tambah</button>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table table-stiped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Sow</th>
                                        <th>Description</th>
                                        <th width="15%"><i class="fas fa-cog"></i></th>

                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });

        //menulis data ke data table
        var table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            responsive: true,
            lengthChange: true,
            processing: true,
            serverSide: true,
            dom: 'Blfrtip',
            buttons: [{
                    extend: 'copy',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                }
            ],
            ajax: "{{ route('sow.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'sow',
                    name: 'sow'
                },
                {
                    data: 'description',
                    name: 'description',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        }).buttons().container().appendTo('.card-body .col-md-6:eq(0)');

        //save data untuk edit atau create
        $('#saveBtn').click(function(e) {
            var formdata = $("#modal-form form").serializeArray();
            var data = {};
            $(formdata).each(function(index, obj) {
                data[obj.name] = obj.value;
            });
            if (validation(data)) {
                $.ajax({
                    data: $('#modal-form form').serialize(),
                    url: "{{ route('sow.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#modal-form').modal('hide');
                        $('.table').DataTable().draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            }

        });


        //memunculkan form edit
        $('body').on('click', '.editStory', function() {
            var id = $(this).data('id');
            console.log(id);
            $.get("{{ route('sow.index') }}" + '/' + id + '/edit', function(data) {
                $('.modal-title').text('Edit Scope Of Work');
                $('#modal-form').modal('show');
                $('#id').val(data.id);
                $('#sow').val(data.sow);
                $('#description').val(data.description);
            })
        });

        $('body').on('click', '.deleteStory', function() {

            var id = $(this).data("id");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('sow.store') }}" + '/' + id,
                success: function(data) {
                    $('.table').DataTable().draw();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        //memunculkan form add
        function addForm() {
            $("#modal-form").modal('show');
            $('#id').val('');
            $('.modal-title').text('Add Scope Of Work');
            $('#modal-form form')[0].reset();
            $('#modal-form [name=sow]').focus();
        }

        //validasi
        function validation(data) {
            let formIsValid = true;
            $('span[id^="error"]').text('');
            if (!data.sow) {
                formIsValid = false;
                $("#error-sow").text('The sow field is required.')
            }
            return formIsValid;
        }

        function submitHandler() {
            $('#saveBtn').click();
        }
    </script>
@endpush
