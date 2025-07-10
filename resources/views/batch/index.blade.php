@extends('layouts.master')
@section('content-header')
    <div class="container-fluid">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Batch</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">home</a></li>
                    <li class="breadcrumb-item active">List Batch</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

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
                                        <th>Batch no</th>
                                        <th>Status</th>
                                        <th>Technology</th>
                                        <th>Trainer</th>
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
@includeIf('batch.form')
@push('scripts')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });

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
            ajax: "{{ route('batch.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'batch_no',
                    name: 'batch_no'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'technologyname',
                    name: 'technology'
                },
                {
                    data: 'trainername',
                    name: 'trainer'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        }).buttons().container().appendTo('.card-body .col-md-6:eq(0)');

        $('#saveBtn').click(function(e) {
            var formdata = $("#modal-form form").serializeArray();
            var data = {};
            $(formdata).each(function(index, obj) {
                data[obj.name] = obj.value;
            });
            if (validation(data)) {
                $.ajax({
                    data: $('#modal-form form').serialize(),
                    url: "{{ route('batch.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#modal-form').modal('hide');
                        $('.table').DataTable().draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }

        });



        $('body').on('click', '.editStory', function() {
            var id = $(this).data('id');
            $.get("{{ route('batch.index') }}" + '/' + id + '/edit', function(data) {
                $('.modal-title').text('Edit Batch');
                $('#modal-form').modal('show');
                $('#id').val(data.id);
                $('#batch_no').val(data.batch_no.slice(1));
                $('#status').val(data.status);
                $('#technology').val(data.technology_id);
                $('#trainer').val(data.trainer_id);
            })
        });

        $('body').on('click', '.deleteStory', function() {

            var id = $(this).data("id");
            confirm("Are You sure want to delete !");
            $.ajax({
                type: "DELETE",
                url: "{{ route('batch.store') }}" + '/' + id,
                success: function(data) {
                    $('.table').DataTable().draw();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        function addForm() {
            $("#modal-form").modal('show');
            $('#id').val('');
            $('.modal-title').text('Add Batch');
            $('#modal-form form')[0].reset();
            $('#modal-form [name=name]').focus();
        }

        function validation(data) {
            let formIsValid = true;
            $('span[id^="error"]').text('');
            if (!data.batch_no) {
                formIsValid = false;
                $("#error-batch_no").text('The batch_no field is required.')
            }
            if (!data.status) {
                formIsValid = false;
                $("#error-status").text('Please Choose status.')
            }
            if (!data.technology) {
                formIsValid = false;
                $("#error-technology").text('Please Choose technology.')
            }
            if (!data.trainer) {
                formIsValid = false;
                $("#error-trainer").text('Please Choose trainer.')
            }
            return formIsValid;
        }

        function submitHandler() {
            $('#saveBtn').click();
        }
    </script>
@endpush
