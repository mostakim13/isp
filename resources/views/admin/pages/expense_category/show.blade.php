<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{$modal_title ?? 'Details'}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal">
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <strong>Name: </strong>
                </div>
                <div class="col-md-8">
                    {{$modal_data->name ?? 'N/A'}}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
    </div>
</div>
