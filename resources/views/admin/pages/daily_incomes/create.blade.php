@extends('admin.master')
@section('content')
<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">
                <div class="card-header">
                    <h4 class="card-title">{{$page_heading ?? 'Create'}}</h4>
                    <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
                </div>
                <x-alert></x-alert>
                <form class="form" action="{{ route('dailyIncome.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12 mb-1">
                            <div class="form-group">
                                <label for="last-name-column">Date</label>
                                <input type="text" class="form-control flatpickr-basic" placeholder="Select date"
                                    name="date" id="date" readonly required />
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-1">
                            <div class="form-group">
                                <label for="email-id-column">Income Category</label>
                                <select class="select2 form-control select2-lg" name="category_id"
                                    aria-label=".select2-lg example">
                                    <option selected disabled>Select category</option>
                                    @foreach ($incomecategories as $incomecategory)
                                    <option value="{{$incomecategory->id}}">{{$incomecategory->service_category_type}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-1">
                            <div class="form-group">
                                <label for="email-id-column">Customer</label>
                                <select class="select2 form-control" name="customer_id">
                                    <option selected value="0">Select Customer</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}}({{$customer->username}})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-1">
                            <div class="form-group">
                                <label for="email-id-column">Supplier</label>
                                <select class="select2 form-control" name="supplier_id">
                                    <option selected value="0">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-1">
                            <div class="form-group">
                                <label for="email-id-column">Account Head</label>
                                <select class="select2 form-control accounthead" onchange="getAvaolableBalance()"
                                    name="account_id">
                                    <option selected disabled>Select Account</option>
                                    @foreach ($accounts as $account)
                                    <option available="{{$account->amount}}" value="{{$account->id}}">
                                        {{$account->account_name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-success account-message"></span>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-1">
                            <div class="form-group">
                                <label for="email-id-column">Service Charge</label>
                                <input type="number" class="form-control" id="amount" min="0" name="amount"
                                    placeholder="Enter amount" required />
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <div class="form-group">
                                <label for="email-id-column">Paid Amount</label>
                                <input type="number" class="form-control" id="paid_amount" min="0" name="paid_amount"
                                    placeholder="Enter amount" required />
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <div class="form-group">
                                <label for="company-column">Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <button href="" type="submit" class="btn btn-primary">Save</button>
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



    var service_charge = document.getElementById("amount");
    var paid_amount = document.getElementById("paid_amount");

    function limit() {
        paid_amount.value = Math.min(Math.round(amount.value * 1), paid_amount.value);
    }

    amount.onchange = limit; 2
    paid_amount.onchange = limit;


    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    document.getElementById("date").value = date;
</script>
@endpush
