@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <x-alert></x-alert>
                <form class="form" action="{{$update_url ?? ""}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-12 text-center">
                            <div class="form-group">
                                <label for="last-name-column">Supplier Name</label>
                                <h3 name="supplier_id">{{$supplierInfo->name}}</h3>
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="last-name-column">Date: </label>
                                <input type="text" id="date" class="form-control" name="date" readonly>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email-id-column">Invoice</label>
                                <select class="select2 form-control select2-lg" id="invoice" onchange="getAmount()"
                                    name="invoice_no" aria-label=".select2-lg example">
                                    <option selected disabled>Select Invoice</option>
                                    @foreach ($invoice as $item)
                                    <option data-amount="{{$item->due_amount}}" value="{{$item->id}}">
                                        {{$item->invoice_no}}</option>
                                    @endforeach
                                </select>
                                <span id="due_amount" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email-id-column">Account</label>
                                <select class="select2 form-control select2-lg" name="account_id"
                                    aria-label=".select2-lg example">
                                    <option selected disabled>Select account</option>
                                    @foreach ($accounts as $account)
                                    <option value="{{$account->id}}">{{$account->account_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email-id-column">Amount</label>
                                <input type="number" class="form-control" name="paid_amount" min="0" id="paid_amount"
                                    placeholder="Enter amount" required />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company-column">Description</label>
                                <input type="text" class="form-control" name="narration" placeholder="Enter description"
                                    required />
                            </div>
                        </div>


                    </div>
                    <div class="mt-2">
                        <button href="" type="submit" class="btn btn-primary">Save</button>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    document.getElementById("date").value = date;

    function getAmount() {
        let amount = $('#invoice option:selected').data('amount');
        $('#due_amount').text('Your Due Amount is ' + amount);
        $('#paid_amount').attr('max', amount);
    }

</script>
@endsection
