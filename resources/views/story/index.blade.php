@extends('layouts.master')
@section('content-header')
    <div class="container-fluid">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Story</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">home</a></li>
                    <li class="breadcrumb-item active">List Story</li>
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
                                Add</button>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table table-stiped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Name</th>
                                        <th width="5%">Score</th>
                                        <th width="5%">Type</th>
                                        <th width="5%">SOW</th>
                                        <th>Priority</th>
                                        <th>Description</th>
                                        <th>Attachment</th>
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
@includeIf('story.form')
@push('scripts')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //validasi score dan priority
            $("#score").change(function() {
                var max = parseInt($(this).attr('max'));
                var min = parseInt($(this).attr('min'));
                if ($(this).val() > max) {
                    $(this).val(max);
                } else if ($(this).val() < min) {
                    $(this).val(min);
                }
            });

            $("#priority").change(function() {
                var max = parseInt($(this).attr('max'));
                var min = parseInt($(this).attr('min'));
                if ($(this).val() > max) {
                    $(this).val(max);
                } else if ($(this).val() <= min) {
                    $(this).val(null);
                }
            });

        });

        //menulis data di datatables
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
            ajax: "{{ route('story.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'score',
                    name: 'score'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'scope',
                    name: 'scope'
                },
                {
                    data: 'priority',
                    name: 'priority',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'description',
                    name: 'description',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'attachment',
                    name: 'attachment',
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

        //save data
        $('#saveBtn').click(function(e) {
            var formdata = $("#modal-form form").serializeArray();
            var data = {};
            $(formdata).each(function(index, obj) {
                data[obj.name] = obj.value;
            });
            if (validation(data)) {
                $.ajax({
                    data: $('#modal-form form').serialize(),
                    url: "{{ route('story.store') }}",
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


        //memunculkan modal edit story
        $('body').on('click', '.editStory', function() {
            var id = $(this).data('id');
            $.get("{{ route('story.index') }}" + '/' + id + '/edit', function(data) {
                $('input[id^="sow"]').prop('checked', false);
                var sow = data.sow;
                $('.modal-title').text('Edit Story');
                $('#modal-form').modal('show');
                for (let i = 0; i < sow.length; i++) {
                    $(`input[id= sow${sow[i].sow_id}]`).prop('checked', true);
                }
                $('#priority').val(data.priority);
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#score').val(data.score);
                $('#type').val(data.type);
                $('#description').val(data.description);
            })
        });

        //delete story
        $('body').on('click', '.deleteStory', function() {
            var id = $(this).data("id");
            confirm("Are You sure want to delete !");
            $.ajax({
                type: "DELETE",
                url: "{{ route('story.store') }}" + '/' + id,
                success: function(data) {
                    $('.table').DataTable().draw();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        //tambah story

        function addForm() {
            $("#modal-form").modal('show');
            $('#id').val('');
            $('.modal-title').text('Add Story');
            $('#modal-form form')[0].reset();
            $('#modal-form [name=name]').focus();
        }

        //validation
        function validation(data) {
            let formIsValid = true;
            $('span[id^="error"]').text('');
            if (!data.name) {
                formIsValid = false;
                $("#error-name").text('The name field is required.')
            }
            if (!data.score) {
                formIsValid = false;
                $("#error-score").text('The score field is required.')
            }
            if (!data.type) {
                formIsValid = false;
                $("#error-type").text('Please Choose type story.')
            }
            return formIsValid;
        }

        //onsubmit form
        function submitHandler() {
            $('#saveBtn').click();
        }
    </script>
@endpush
