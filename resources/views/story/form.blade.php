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
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required autofocus>
                        <span class="text-danger" id="error-name"></span>
                    </div>
                    <div class="form-group">
                        <label for="score">Score</label>
                        <input type="number" name="score" min="1" max="99" step="2" id="score" class="form-control">
                        <span class="text-danger" id="error-score"></span>
                    </div>
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <input type="number" name="priority" min="0" max="999" step="3" id="priority" class="form-control">
                        <span class="text-danger" id="error-score"></span>
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" name="type" id="type" required>
                            <option value="" selected disabled hidden>Choose Type</option>
                            <option value="M">M</option>
                            <option value="T">T</option>
                            <option value="R">R</option>
                        </select>
                        <span class="text-danger" id="error-type"></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">SOW</label>
                        <br>
                        @foreach ($sow as $index=>$sow)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="sow[{{ $index }}]" id="sow{{ $sow->id }}" value="{{ $sow->id }}">
                                <label class="form-check-label" for="sow">{{ $sow->sow }}</label>
                            </div>
                        @endforeach 
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
