@extends('layouts.master')
@section('content')
    <div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
        <header style="width: 985.4px;">
            <div class="container">
                <h1 style="border-top-left-radius: 0px;">Project Board: Batch {{ $batch->batch_no }} &nbsp;</h1>
            </div>
        </header>
        <hr class="mb-4" style="background: var(--orange);border-style: solid;height: 4px;">
        <div class="container-fluid mb-4">
            <div class="row">
                <div class="col" style="width: 300px;">
                    <div class="card bg-light card-project ">
                        <div class="card-header">Assignment</div>
                        <div class="card-body List1" data-status="assignment">
                            @foreach ($assignment as $assignment)
                                <div class="card card-project-board"
                                    style="background: var(--{{ story_color($assignment->story->type) }});"
                                    data-story-id="{{ $assignment->story_id }}" data-pb-id=""
                                    ondblclick="modalstory({{ $assignment->story_id }})">
                                    <div class="card-body text-center">
                                        <span class="pull-right clickable close-icon float-right" style="display:none;"
                                            id="closeicon{{ $assignment->story_id }}"
                                            onclick="closeicon({{ $assignment->story_id }})">
                                            <i class="fa fa-times"></i>
                                        </span>
                                        <p class="m-auto" style="  color: var(--white);">
                                            {{ '[' . $assignment->story->type . score_story($assignment->story->score) . ']' . $assignment->story->name }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col" style="width: 300px;">
                    <div class="card bg-light card-project ">
                        <div class="card-header">My Plan</div>
                        <div class="card-body List2" data-status="plan">
                            @foreach ($project_board as $pb)
                                @if ($pb->status == null)
                                    <div class="card card-project-board"
                                        style="background: var(--{{ story_color($pb->story->type) }});"
                                        data-story-id="{{ $pb->story_id }}" data-pb-id="{{ $pb->id }}"
                                        ondblclick="modalstory({{ $pb->story_id }})">
                                        <div class="card-body text-center">
                                            <span class="pull-right clickable close-icon float-right"
                                                id="closeicon{{ $pb->story_id }}"
                                                onclick="closeicon({{ $pb->story_id }})">
                                                <i class="fa fa-times"></i>
                                            </span>
                                            <p class="m-auto" style="  color: var(--white);">
                                                {{ '[' . $pb->story->type . score_story($pb->story->score) . ']' . $pb->story->name }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col" style="width: 300px;">
                    <div class="card bg-light card-project ">
                        <div class="card-header">Development</div>
                        <div class="card-body List3" data-status="O">
                            @foreach ($project_board as $pb)
                                @if ($pb->status == 'O')
                                    <div class="card card-project-board"
                                        style="background: var(--{{ story_color($pb->story->type) }});"
                                        data-story-id="{{ $pb->story_id }}" data-pb-id="{{ $pb->id }}"
                                        ondblclick="modalstory({{ $pb->story_id }})">
                                        <div class="card-body text-center">
                                            <span class="pull-right clickable close-icon float-right" style="display:none;"
                                                id="closeicon{{ $pb->story_id }}" onclick="closeicon($pb->story_id)">
                                                <i class="fa fa-times"></i>
                                            </span>
                                            <p class="m-auto" style="  color: var(--white);">
                                                {{ '[' . $pb->story->type . score_story($pb->story->score) . ']' . $pb->story->name }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col" style="width: 300px;">
                    <div class="card bg-light card-project ">
                        <div class="card-header">Done</div>
                        <div class="card-body List4" data-status="D">
                            @foreach ($project_board as $pb)
                                @if ($pb->status == 'D')
                                    <div class="card card-project-board"
                                        style="background: var(--{{ story_color($pb->story->type) }});opacity: .6;"
                                        data-story-id="{{ $pb->story_id }}" data-pb-id="{{ $pb->id }}"
                                        ondblclick="modalstory({{ $pb->story_id }})">
                                        <div class="card-body text-center">
                                            <span class="pull-right clickable close-icon float-right" style="display:none;"
                                                id="closeicon{{ $pb->story_id }}" onclick="closeicon($pb->story_id)">
                                                <i class="fa fa-times"></i>
                                            </span>
                                            <p class="m-auto" style="  color: var(--white);">
                                                {{ '[' . $pb->story->type . score_story($pb->story->score) . ']' . $pb->story->name }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-md-12" style="overflow-x: scroll; white-space: nowrap;">
                    @foreach ($d_batch_student as $dbs)
                        <div class="card d-inline-flex bg-light mr-5 card-project">
                            <div class="card-header">{{ $dbs->user->fullname }}</div>
                            <div class="card-body List">
                                @foreach ($dbs->pb as $pb)
                                    <div class="card card-project-board clickable"
                                        style="background: var(--{{ story_color($pb->story->type) }});"
                                        data-story-id="{{ $pb->story_id }}" onclick="modalstory({{ $pb->story_id }})">
                                        <div class="card-body text-center">
                                            <p class="m-auto" style="  color: var(--white);">
                                                {{ '[' . $pb->story->type . score_story($pb->story->score) . ']' . $pb->story->name }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal-story">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-story-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            //drag and drop dari assignment ke myplan
            window.onload = function() {
                var batch_id = {{ $batch->id }};
                $('.List1, .List2').sortable({
                    appendTo: '.row',
                    cursor: "grabbing",
                    tolerance: 'pointer',
                    revert: 'invalid',
                    forceHelperSize: true,
                    helper: 'original',
                    scroll: true,
                    connectWith: ".List1, .List2"
                }).disableSelection();

                //drag and drop dari myplan ke development dan done
                $('.List2, .List3, .List4').sortable({
                    appendTo: '.row',
                    cursor: "grabbing",
                    tolerance: 'pointer',
                    revert: 'invalid',
                    forceHelperSize: true,
                    helper: 'original',
                    scroll: true,
                    connectWith: ".List3, .List4",
                    receive: function(e, ui) {
                        var story_id = $(ui.item).data("story-id");
                        var status = $(ui.item).parent(".card-body").data("status");
                        var id = $(ui.item).data("pb-id");
                        $(`div[data-story-id= ${story_id}]`).css("opacity", 1);
                        $("#closeicon" + story_id).css("display", "none");
                        if (status == "plan") {
                            $("#closeicon" + story_id).css("display", "block");
                            status = null;
                        } else if (status == "D") {
                            $(`div[data-story-id= ${story_id}]`).css("opacity", .6);
                        }
                        $.ajax({
                            type: "post",
                            url: "{{ url('projectboard') }}",
                            data: {
                                '_token': $('meta[name=csrf-token]').attr('content'),
                                id: id,
                                story_id: story_id,
                                status: status
                            },
                            success: function(data) {
                                $(ui.item).data('pb-id', data);
                            }
                        });
                    }
                }).disableSelection();
            }

            //handle jika close icon diclick akan cancel mengambil assignment
            function closeicon(id) {
                console.log(id)
                $(`div[data-story-id= ${id}]`).appendTo("div[data-status=assignment]");
                $("#closeicon" + id).css("display", "none");
                var pb_id = $(`div[data-story-id= ${id}]`).data("pb-id");
                $.ajax({
                    type: "delete",
                    url: "{{ url('projectboard') }}/" + pb_id,
                    data: {
                        '_token': $('meta[name=csrf-token]').attr('content')
                    },
                    success: function(data) {
                        console.log(data)
                    }
                });
            }

            //membuka modal story
            function modalstory(id) {
                $.get("{{ url('modalstory') }}/" + id, {}, function(data, status) {
                    $(".modal-content").html(data);
                    $("#modal-story").modal('show');
                });
            }
        </script>
    </div>
@endsection
