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
                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Date<span class="text-danger">*</span></label>
                                <input type="date" value="{{$editinfo->_date}}" class="form-control input-rounded"
                                    name="_date">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Asset Name</label>
                                <input type="text" class="form-control input-rounded" name="name"
                                    value="{{$editinfo->name}}" placeholder="Asset name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Asset Category</label>
                                <select class="select2 form-control" name="category_asset_id"
                                    aria-label=".select2-lg example">
                                    <option selected disabled>Select category</option>
                                    @foreach ($assets as $asset)
                                    <option value="{{$asset->id}}" {{ $asset->id == $editinfo->category_asset_id ?
                                        'selected':'' }}>{{$asset->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Account Head</label>
                                <select class="select2 form-control accounthead" onchange="availablebalance()"
                                    name="account_id">
                                    <option selected disabled>Select Account</option>
                                    @foreach ($accounts as $account)
                                    <option {{$account->id == $editinfo->account_id ? "selected":""}}
                                        available="{{$account->amount}}" value="{{$account->id}}">
                                        {{$account->account_name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-success account-message"></span>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Quantity(PCs)</label>
                                <input type="number" class="form-control input-rounded" name="qty"
                                    value="{{$editinfo->qty}}" placeholder="Quantity">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Amount</label>
                                <input type="number" class="form-control input-rounded" name="amount"
                                    value="{{$editinfo->amount}}" placeholder="Amount">
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
    function availablebalance() {
        let availablebalance = $('.accounthead option:selected').attr('available');
        $('.account-message').text('Available Balance is ' + availablebalance);
    }

    availablebalance();

    $('.assetvalue').on('input', function () {
        let availablebalance = $('.accounthead option:selected').attr('available');
        let amount = $(this).val();
        if (Number(amount) > availablebalance) {
            $(this).val(availablebalance);
            return true;
        }
    })
</script>
@endpush
