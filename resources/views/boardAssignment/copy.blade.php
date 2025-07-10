<div class="modal-header" style="border-style: none;">
    <h4 class="modal-title" style="color: var(--orange);">Copy from batch</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" style="color: var(--orange);">×</span>
    </button>
</div>
<div class="modal-body" style="border-style: none;">
    <form>
        <div class="field">
            <label class="mb-0" for="float-input" style="color: var(--orange);">Batch No</label>
            <select class="form-control border-o" id="copy-batch">
                <optgroup label="Pilih batch">
                    <option value="" selected disabled hidden>Pilih batch</option>
                    @foreach ($data as $batch)
                        <option value="{{ $batch->id }}">Batch {{ $batch->batch_no }}</option>
                    @endforeach
                </optgroup>
            </select>
            <span class="text-danger" id="batch-error" style="display: none">Please select a valid Batch.</span>
        </div>
    </form>
</div>
<div class="modal-footer" style="border-style: none;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <button class="btn btn-lg btn-drop" type="button" data-dismiss="modal">Back</button>
            </div>
            <div class="col-md-6 text-center">
                <button class="btn btn-lg btn-add-ass" type="button"
                    onclick="selecthandle()">Select</button>
            </div>
        </div>
    </div>
</div>