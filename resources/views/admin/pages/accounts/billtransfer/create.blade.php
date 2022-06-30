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
                                <label for=""> Payment Method <span class="text-danger">*</span></label>
                                <select name="local_id" class="form-control select2 payMeth"
                                    onchange="availableBalance()" id="">
                                    <option selected disabled>Select</option>
                                    @foreach($paymentmethods as $paymentmethod)
                                    <option available="{{$paymentmethod->amount}}" value="{{$paymentmethod->id}}">
                                        {{$paymentmethod->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-success balance-message"></span>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for=""> Account <span class="text-danger">*</span></label>
                                <select name="account_id" class="form-control select2 " id="">
                                    <option selected disabled>Select</option>
                                    @foreach($accounts as $account)
                                    <option value="{{$account->id}}">
                                        {{$account->account_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Amount</label>
                                <input type="number" class="form-control input-rounded" name="amount"
                                    placeholder="Ex:2000">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Note</label>
                                <textarea name="note" class="form-control"></textarea>

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
    function availableBalance() {
        let balance = $('.payMeth option:selected').attr('available');
        $('.balance-message').text('Available balance is ' + balance);
    }
</script>
@endpush
