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
                    <form action="{{ $store_url ?? '#' }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label>Expense Category</label>
                                <select name="expense_category_id" class="select2 default-select form-control wide">
                                    <option selected="selected" disabled>Select Expense</option>
                                    @foreach ($categories as $key => $value)
                                    <option value="{{ $value->id }}">
                                        {{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Select Customer</label>
                                <select name="customer_id" class="select2 default-select form-control wide">
                                    <option selected="selected" disabled>Select Customer</option>
                                    @foreach ($customers as $key => $value)
                                    <option value="{{ $value->id }}">
                                        {{ $value->name }}({{ $value->username }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Account</label>
                                <select name="account_id" class="select2 accounthead form-control"
                                    onchange="getAvaolableBalance()">
                                    <option selected="selected" disabled>Select Account</option>
                                    @foreach ($account as $key => $value)
                                    <option available="{{$value->amount}}" value="{{ $value->id }}">
                                        {{ $value->account_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-success account-message"></span>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label>Payment Method</label>
                                <select name="pay_method_id" class="select2 paymethod form-control"
                                    onchange="getAvaolableBalanceFromPayMethod()">
                                    <option selected="selected" disabled>Select Account</option>
                                    @foreach ($payMethods as $value)
                                    <option available="{{$value->amount}}" value="{{ $value->id }}">
                                        {{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-success method-message"></span>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label>Amount</label>
                                <input type="number" class="form-control input-rounded" name="amount"
                                    placeholder="Amount">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Date</label>
                                <input type="text" id="date" readonly name="date" value="{{ old('date') }}"
                                    class="form-file-input form-control ">
                            </div>
                            <div class="col-md-12 mb-1">
                                <label>Note</label>
                                <textarea type="text" class="form-control " name="note"
                                    placeholder="Note here"></textarea>
                            </div>
                        </div>

                        <div class="form-group mb-1">
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
        // changevalue('.paymethod', '.method-message', '.paymethod :selected');
        $('.account-message').text('Available Balance is ' + availablebalance);
    }


    function getAvaolableBalanceFromPayMethod() {
        let availablebalance = $('.paymethod option:selected').attr('available');
        // changevalue('.accounthead', '.account-message', '.paymethod :selected');
        $('.method-message').text('Available Balance is ' + availablebalance);
    }

    function changevalue(selectClass, messageClass, checkselect) {
        let selectoption = $(checkselect).length;
        if (selectoption > 0) {
            $(selectClass).trigger("change");
            $(messageClass).text('');
        }
    }
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    document.getElementById("date").value = date;
</script>
@endpush
