<div class="modal-header" style="border-style: none;">
    <h4 class="modal-title" style="color: var(--orange);">Drop Assignment</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" style="color: var(--orange);">×</span>
    </button>
</div>
<div class="modal-body" style="border-style: none;">
    <div class="modal-body text-center" style="border-style: none;">
        <h5>Are you sure to drop assignment from Batch {{ $data->batch_no }}</h5>
    </div>
</div>
<div class="modal-footer" style="border-style: none;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <button class="btn btn-lg btn-drop" type="button" data-dismiss="modal">Back</button>
            </div>
            <div class="col-md-6 text-center">
                <button class="btn btn-lg btn-add-ass" type="button"
                    onclick="drophandle({{ $data->id }})">Drop</button>
            </div>
        </div>
    </div>
</div>