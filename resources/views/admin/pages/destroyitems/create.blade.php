@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Create'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Asset Name <span class="text-danger">*</span></label>
                                <select class="select2 form-control assetlist" onchange="assetQty()" name="asset_id">
                                    <option selected disabled>Select asset</option>
                                    @foreach ($assets as $asset)
                                    <option qty="{{$asset->qty}}" value="{{$asset->id}}">{{$asset->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-success currentqty"></span>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Reason</label>
                                <select class="select2 form-control" name="reason_id">
                                    <option selected disabled>Select reason</option>
                                    @foreach ($reasons as $reason)
                                    <option value="{{$reason->id}}">{{$reason->reason_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Quantity</label>
                                <input type="number" class="form-control input-rounded" name="qty"
                                    placeholder="Quantity">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Date</label>
                                <input type="date" class="form-control input-rounded" name="destroy_date"
                                    placeholder="Destroy Date">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for=""> Remarks</label>
                                <input type="text" class="form-control input-rounded" name="remarks"
                                    placeholder="Remarks">
                            </div>

                        </div>

                        <div class="mb-1 form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function assetQty() {
        let availableQty = $('.assetlist option:selected').attr('qty');
        $('.currentqty').text('Available Quantity is ' + availableQty);
    }
</script>
@endpush
