@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Edit'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label>Expense Category</label>
                                <select name="expense_category_id" class="select2  form-control">
                                    <option selected="selected" disabled>Select Expense</option>
                                    @foreach ($categories as $key => $value)
                                    <option value="{{ $value->id }}" {{ $value->id == $editinfo->expense_category_id ?
                                        'selected':'' }}>
                                        {{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Customer</label>
                                <select name="customer_id" class="select2 form-control">
                                    <option selected="selected" disabled>Select Customer</option>
                                    @foreach ($customers as $key => $value)
                                    <option value="{{ $value->id }}" {{ $value->id == $editinfo->customer_id ?
                                        'selected':'' }}>
                                        {{ $value->name }}({{ $value->username }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @if($editinfo->account_id)
                            <div class="col-md-6 mb-1">
                                <label>Account</label>
                                <select name="account_id" class="select2 accounthead form-control"
                                    onchange="getAvaolableBalance()">
                                    <option selected disabled>Select Account</option>
                                    @foreach ($accounts as $key => $value)
                                    <option {{ $value->id == $editinfo->account_id ?
                                        'selected':'' }} available="{{$value->amount}}" value="{{ $value->id }}">
                                        {{ $value->account_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-success account-message"></span>
                            </div>
                            @endif

                            @if($editinfo->pay_method_id)
                            <div class="col-md-6 mb-1">
                                <label>Payment Method</label>
                                <select name="pay_method_id" class="select2 paymethod form-control"
                                    onchange="getAvaolableBalanceFromPayMethod()">
                                    <option selected="selected" disabled>Select Account</option>
                                    @foreach ($payMethods as $value)
                                    <option {{ $value->id == $editinfo->pay_method_id ?
                                        'selected':'' }} available="{{$value->amount}}" value="{{ $value->id }}">
                                        {{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-success method-message"></span>
                            </div>
                            @endif
                            <div class="col-md-6 mb-1">
                                <label>Amount</label>
                                <input type="number" value="{{ $editinfo->amount }}" class="form-control input-rounded"
                                    name="amount" placeholder="Amount">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Date</label>
                                <input type="text" id="date" readonly name="date" value="{{ old('date') }}"
                                    class="form-file-input form-control ">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Note</label>
                                <textarea type="text" class="form-control " name="note" placeholder="Note here">
                                {{ $editinfo->note }}</textarea>
                            </div>
                        </div>

                        <div class=" form-group">
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
<script type="text/javascript">

    function getAvaolableBalance() {
        let availablebalance = $('.accounthead option:selected').attr('available');
        $('.account-message').text('Available Balance is ' + availablebalance);
    }

    function getAvaolableBalanceFromPayMethod() {
        let availablebalance = $('.paymethod option:selected').attr('available');
        $('.method-message').text('Available Balance is ' + availablebalance);
    }

    if ('{{$editinfo->pay_method_id}}') {
        getAvaolableBalanceFromPayMethod();
    }
    if ('{{$editinfo->account_id}}') {
        getAvaolableBalance();
    }
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    document.getElementById("date").value = date;
</script>
@endpush
