<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form onSubmit="JavaScript:submitHandler()"  action="javascript:void(0)" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" class="form-control">
                    <div class="form-group">
                        <label for="batch_no">Batch no</label>
                        <input type="text" name="batch_no" id="batch_no" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required autofocus>
                        <span class="text-danger" id="error-batch_no"></span>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="" selected disabled hidden>Choose Status</option>
                            <option value="D">Done</option>
                            <option value="O">Ongoing</option>
                        </select>
                        <span class="text-danger" id="error-status"></span>
                    </div>
                    <div class="form-group">
                        <label for="technology">Technology</label>
                        <select class="form-control" name="technology" id="technology" required>
                            <option value="" selected disabled hidden>Choose technology</option>
                            @foreach ($technology as $technology)
                            <option value="{{ $technology->id }}">{{ $technology->name }}</option>    
                            @endforeach
                        </select>
                        <span class="text-danger" id="error-technology"></span>
                    </div>
                    <div class="form-group">
                        <label for="trainer">Trainer</label>
                        <select class="form-control" name="trainer" id="trainer" required>
                            <option value="" selected disabled hidden>Choose trainer</option>
                            @foreach ($trainer as $trainer)
                            <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>    
                            @endforeach
                        </select>
                        <span class="text-danger" id="error-trainer"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-flat btn-primary" id="saveBtn"><i
                            class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i
                            class="fa fa-arrow-circle-left"></i> Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
