    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-assigment" id="board">
                    <div class="card-body List1" data-status="assignment">
                    @if (count($assignment) === 0)
                        <span class="m-auto" style="color: var(--orange);" id="no-assignment">No
                            Assignment</span>
                    @endif
                    @foreach ($assignment as $data)
                        <div class="card card-assigment-isi clickable"
                            id="story{{ $data->story_id }}" data-story-id="{{ $data->story_id }}">
                            <div class="card-body text-center">
                                <span class="pull-right clickable float-right" id="closeicon{{ $data->story_id }}"
                                    onclick="closeicon({{ $data->story_id }})">
                                    <i class="fa fa-times"></i>
                                </span>
                                <p class="m-auto" style="color: var(--white);">{{ $data->storyname }}</p>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-assigment" id="btn-assignment">
                    <div class="card-body List2" data-status="story">
                    @foreach ($data_story as $data)
                        <div class="card card-assigment-isi clickable" id="story{{ $data->id }}"
                            data-story-id="{{ $data->id }}" value="1">
                            <div class="card-body text-center">
                                <span class="pull-right clickable float-right" style="display:none;"
                                    id="closeicon{{ $data->id }}" onclick="closeicon({{ $data->id }})">
                                    <i class="fa fa-times"></i>
                                </span>
                                <p class="m-auto" style="color: var(--white);">
                                    [{{ $data->type . score_story($data->score) }}]{{ $data->name }}</p>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid" id="addedit-btn">
            <div class="row">
                <div class="col-md-6 text-center">
                    <button class="btn btn-lg btn-drop" type="button" onclick="cancelhandle()">Cancel</button>
                </div>
                <div class="col text-center">
                    <button class="btn btn-lg btn-add-ass" type="button" onclick="savehandle()">Save</button>
                </div>
            </div>
        </div>
        <div role="dialog" tabindex="-1" class="modal fade show" id="cancelModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-border">
                    <div class="modal-header" style="border-style: none;">
                        <h4 class="modal-title" style="color: var(--orange);">cancel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: var(--orange);">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center" style="border-style: none;">
                        <h5>Are you sure to cancel any changes?</h5>
                    </div>
                    <div class="modal-footer" style="border-style: none;">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <button class="btn btn-lg btn-drop" type="button" data-dismiss="modal">Back</button>
                                </div>
                                <div class="col-md-6 text-center">
                                    <button class="btn btn-lg btn-add-ass" type="button"
                                        onclick="okehandle(batch_id)">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            //save untuk data yang akan di save
            var save = [];
            //del untuk data assignment yang di delete
            var del = [];
            var batch_id = {{ $batch_id }}

            //membuat sortable pada card assignment mati
            $("div[data-status=story]").hover(function() {
                $(".List1, .List2").sortable('enable');
            }, function() {
                $(".List1, .List2").sortable('disable');
            });

            //sortable agar bisa drag and drop
            $('.List1, .List2').sortable({
                containment: "document",
                cursor: "move",
                appendTo: "body",
                tolerance: 'pointer',
                revert: 'invalid',
                forceHelperSize: true,
                helper: 'original',
                scroll: true,
                connectWith: ".List1",
                receive: function(e, ui) {
                    $('#no-assignment').css("display", "none");
                    var story_id = $(ui.item).data("story-id");
                    var status = $(ui.item).parent(".card-body").data("status");
                    //yang dilakukan ketika story jatuh pada card assignment atau bukan
                    if (status == "assignment") {
                        $("#closeicon" + story_id).css("display", "block");
                        save.push(story_id);
                        var index_del = del.indexOf(story_id);
                        if (index_del !== -1) {
                            del.splice(index_del, 1);
                        }
                    } else {
                        $("#closeicon" + story_id).css("display", "none");
                        save.pop()
                    }
                }

            }).disableSelection();

            //close icon untuk membalikan card story
            function closeicon(id) {
                $("#story" + id).appendTo(".List2");
                $("#closeicon" + id).css("display", "none");
                var index_del = del.indexOf();
                if (index_save !== -1) {
                    del.push(id)
                }
                var index_save = save.indexOf(id);
                if (index_save !== -1) {
                    save.splice(index_save, 1);
                }
            }

            //savehandle untuk save data yang sudah di ubah
            function savehandle() {
                //copy id adalah id batch yang akan dicopy
                var copy_id = $('#copy-batch').val()
                //select adalah id batch yang akan di save
                var select = $('select[name=select-batch]').val();
                //jika habis melakukan copy memanggil fungsi copyhandle
                if (copy_id != undefined) {
                    copyhandle(copy_id, select)
                }
                //save data yang sudah di ubah
                $.ajax({
                    type: "post",
                    url: "{{ url('boardassignment') }}",
                    data: {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        batch_id: select,
                        save: this.save.sort(),
                        del: this.del.sort()
                    },
                    success: function(data) {
                        okehandle(data)
                        $(".card-assigment").sortable('disable');
                    }
                });

            }

            //oke handle untuk button oke setelah memencet button cancle
            function okehandle(id) {
                $.ajax({
                    type: "get",
                    url: "{{ url('boardassignment') }}/" + id,
                    success: function(data) {
                        $('input[name=Technology]').val(data.technology.name);
                        $("#btn-assignment").html(data.btn);
                        $("#board").html(data.board);
                        $("#board").addClass("overflow-auto");
                        $("#addedit-btn").html("");
                        $("#cancelModal").modal('hide');
                    }
                });
            }

            //cancel handle untuk button cancel
            function cancelhandle() {
                $("#cancelModal").modal('show');
                $(".card-assigment").sortable('disable');
            }

            //melakukan copy data jika melakukan copy
            function copyhandle(copy, select) {
                $('#copy-batch').val(undefined);
                $.ajax({
                    type: "post",
                    url: "{{ url('boardassignmentcopy') }}",
                    data: {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        select: select,
                        copy: copy
                    },
                    success: function(data) {}
                });
            }
        </script>
    </div>
