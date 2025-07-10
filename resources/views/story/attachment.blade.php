<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attachment {{ $story->type . "[$story->score]" . $story->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div>
            <a href="{{ url('story') }}" type="button" class="btn btn-success">Back</a>
        </div>
        <br />
        <h3 align="center" id="att-title" data-id={{ $story->id }}>Attachment
            {{ $story->type . '[' . score_story($story->score) . ']' . $story->name }}</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Select Image</h3>
            </div>
            <div class="panel-body">
                <form id="dropzoneForm" class="dropzone dz-clickable" action="{{ route('attachment.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="id" class="form-control"
                        value="{{ $story->id }}">
                </form>
                <div align="center">
                    <button type="button" class="btn btn-info" id="submit-all">Upload</button>
                </div>
            </div>
        </div>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Uploaded Image</h3>
            </div>
            <div class="panel-body" id="uploaded_image">

            </div>
        </div>
    </div>
</body>

</html>

<script type="text/javascript">
    //membuat dropzone agar bisa upload beberapa data segaligus
    Dropzone.options.dropzoneForm = {
        autoProcessQueue: false,
        acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.pdf",

        init: function() {
            var submitButton = document.querySelector("#submit-all");
            myDropzone = this;
            submitButton.addEventListener('click', function() {
                myDropzone.processQueue();

            });

            this.on("complete", function() {
                if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length ==
                    0) {
                    var _this = this;
                    _this.removeAllFiles();
                }
                load_images();
            });

        }

    };

    load_images();

    //load data pertama
    function load_images() {
        var id = $('#att-title').data('id');
        $.ajax({
            data: {
                id: id
            },
            url: "{{ route('attachment.index') }}",
            success: function(data) {
                // console.log(data)
                $('#uploaded_image').html(data);
            },
            error: function(data) {
                console.log('Error:', data);
            }
        })
    }

    //hapus attachment
    $(document).on('click', '.remove_image', function() {
        var id = $(this).attr('id');
        $.ajax({
            type: "DELETE",
            url: "{{ route('attachment.store') }}" + '/' + id,
            data: {
                '_token': $('meta[name=csrf-token]').attr('content')
            },
            success: function(data) {
                load_images();
            }
        })
    });
</script>
