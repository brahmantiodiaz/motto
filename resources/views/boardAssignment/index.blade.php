@extends('layouts.master')
@section('content')
    <div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
        <header style="width: 985.4px;">
            <div class="container">
                <h1 style="border-top-left-radius: 0px;">Board Assigment</h1>
            </div>
        </header>
        <hr class="mb-4" style="background: var(--orange);border-style: solid;height: 4px;" />
        <div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <form>
                            <div class="field">
                                <label class="mb-0" for="float-input">Batch No</label>
                                <select class="form-control border-o" name="select-batch">
                                    <optgroup label="Pilih batch">
                                        <option value="" selected disabled hidden>Pilih batch</option>
                                        @foreach ($batch as $batchs)
                                            <option value="{{ $batchs->id }}">Batch {{ $batchs->batch_no }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form>
                            <div class="field">
                                <label class="mb-0" for="float-input">Team Count</label>
                                <input type="text" class="form-control border-o" disabled="" value="6" name="team-count" />
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form>
                            <div class="field">
                                <label class="mb-0" for="float-input">Technology</label>
                                <input type="text" class="form-control border-o" disabled="" id="tech" value="-"
                                    name="Technology" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mb-4" style="background: var(--orange);border-style: solid;height: 4px;" />
        <div id="isi">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-assigment" id="board">
                            <span class="m-auto" style="color: var(--orange);">No Assignment</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-assigment" id="btn-assignment">
                            <button class="btn btn-lg m-auto btn-add-ass" type="button" name="card-btn" disabled>Add/Edit
                                Assigment</button>
                            <button class="btn btn-lg m-auto btn-copy" type="button" name="card-btn" disabled>Copy from
                                Batch</button>
                            <button class="btn btn-lg m-auto btn-drop" type="button" name="card-btn" disabled>Drop
                                Assigment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="dialog" tabindex="-1" class="modal fade show" id="main-modal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-border">
                    <div id="modal"></div>
                </div>
            </div>
        </div>
        <script>
            window.onload = function() {
                //memilih batch
                $('select[name=select-batch]').on('change', function() {
                    var id = this.value;
                    read(id)

                });
            }

            function read(id) {
                //fetch data sesuai dengan batch//
                $.ajax({
                    type: "get",
                    url: "{{ url('boardassignment') }}/" + id,
                    success: function(data) {
                        $('input[name=Technology]').val(data.technology.name);
                        $("#btn-assignment").html(data.btn);
                        $("#board").html(data.board);
                        $("#board").addClass("overflow-auto");
                        $("#addedit-btn").html("");
                        $(".card-assigment").sortable('disable');
                    }
                });
            }
            //button Add/edit assignment 
            function Add(id) {
                $.get("{{ url('boardassignment') }}/" + id + "/edit", {}, function(data, status) {
                    $("#isi").html(data);
                });
            }

            //memunculkan modal drop
            function Drop(id) {
                $.get("{{ url('boardassignmentdrop') }}/" + id, {}, function(data, status) {
                    $("#modal").html(data);
                    $("#main-modal").modal('show');
                });
            }

            //memunculkan modal untuk batch yang akan di copy
            function Copy(id) {
                $.get("{{ url('boardassignmentcopy') }}/" + id, {}, function(data, status) {
                    $("#modal").html(data);
                    $("#main-modal").modal('show');
                });
            }

            //select dan mengubah data sesuai batch yg di copy
            function selecthandle() {
                var copy = $('#copy-batch').val()
                if (copy == null) {
                    $("#batch-error").css("display", "block");
                } else {
                    $("#main-modal").modal('hide');
                    Add(copy)
                }
            }

            //menghapus semua assignment dalam batch tsb
            function drophandle(id) {
                $.ajax({
                    type: "delete",
                    url: "{{ url('boardassignment') }}/" + id,
                    data: {
                        '_token': $('meta[name=csrf-token]').attr('content')
                    },
                    success: function(data) {
                        $("#main-modal").modal('hide');
                        read(data)
                    }
                });
            }
        </script>
    </div>
@endsection
