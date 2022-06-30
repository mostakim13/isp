@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Pay'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">

                    <div class="col-lg-12">
                        <h4 class="card-title">
                            {{$billing->getCustomer->name}}({{$billing->getCustomer->username}}) Payment
                            Information</h4>

                        <div class="table-responsive">
                            <table class="table table-bordered table-responsive-sm">
                                <thead class="thead-primary">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Mobile No</th>
                                        <th scope="col">Speed</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Due</th>
                                        <th scope="col">IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $setPartial = 0;
                                    @endphp
                                    @foreach($customerDetails as $key=>$customer)
                                    @php
                                    $setPartial += $customer->partial;
                                    @endphp
                                    <tr>
                                        <th>{{$key + 1}}</th>
                                        <td>{{$customer->getCustomer->name ?? 'N/A'}}</td>
                                        <td>{{$customer->getCustomer->address ?? 'N/A'}}</td>
                                        <td>{{$customer->getCustomer->phone ?? 'N/A'}}</td>
                                        <td>{{$customer->getCustomer->speed ?? 'N/A'}}
                                        </td>
                                        <td>{{
                                            Carbon\Carbon::parse($customer->date_)->format('F-Y')
                                            }}
                                        </td>
                                        <td>{{$customer->customer_billing_amount}}</td>
                                        <td>{{$customer->partial}}</td>
                                        <td>{{$customer->getCustomer->ip_address}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <hr>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="">Service Amount</label>
                                <input type="text" class="form-control" id="service_amount" readonly
                                    value="{{ $data->getCustomer->bill_amount }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="">Payment Type</label>
                                <select name="pay_type" onchange="payType(this.value)" class="form-control">
                                    <option selected disabled>Select Type</option>
                                    <option value="full_pay">Full Payment</option>
                                    <option value="partial">Due Payment</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3 payMonth" style="display: none;">
                                <label for="">Payment Month</label>
                                <select name="month" class="form-control select2" onchange="payMonth()"
                                    id="paymentMonth">
                                    <option selected disabled>Select Month</option>
                                    @foreach($customerDetails as $customer)
                                    <option dueamount={{$customer->customer_billing_amount}} value="{{$customer->id}}">
                                        {{Carbon\Carbon::parse($customer->date_)->format('F-Y')}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 ">
                                <label for="">Payment Method</label>
                                <select name="payment_method_id" class="form-control">
                                    <option value="">Select Method</option>
                                    @foreach($paymentMethods as $payment)
                                    <option value="{{$payment->id}}">
                                        {{$payment->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="">Pay Amount</label>
                                <input type="text" class="form-control" readonly disabled
                                    value="{{$data->getCustomer->total_paid ?? '0'}}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="">Due</label>
                                <input type="number" class="form-control dueInpute" readonly disabled
                                    value="{{$data->getCustomer->due ?? '0'}}">
                            </div>

                            <div class="col-md-3 mb-3 payAmount" style="display: none;">
                                <label for="">Payment Amount</label>
                                <input type="number" name="pay_amount" class="form-control ">
                            </div>
                            <div class="col-md-3 mb-3 discountfile" style="display: none;">
                                <label for="">Discount(optional)</label>
                                <input type="number" class="form-control discounts_val"
                                    max="{{$data->getCustomer->bill_amount}}" onkeyup="discounts(this.value)"
                                    name="discount">
                            </div>
                            <div class="col-md-3 mb-3 extendDate" style="display: none;">
                                <label for="">Extend date</label>
                                <input type="number" name="extend_date" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Payment Description</label>
                                <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    <hr>
                    <div class="col-lg-12">
                        <h4 class="card-title">View Payment Details</h4>

                        <div class="table-responsive">
                            <table class="table table-bordered table-responsive-sm">
                                <thead class="thead-primary">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Month</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Pay Amount</th>
                                        <th scope="col">Billing By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $totalpay = 0;
                                    @endphp
                                    @foreach($customerPaymentDetails as $key=>$customer)
                                    @php
                                    $totalpay += $customer->pay_amount;
                                    @endphp
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{Carbon\Carbon::parse($customer->updated_at)->format('h:i d,M,Y')}}</td>
                                        <td>{{Carbon\Carbon::parse($customer->date_)->format('F')}}</td>
                                        <td>{{ $customer->PaymentMethod->name }}</td>
                                        <td>{!! $customer->description !!}</td>
                                        <td>{{ $customer->discount }}</td>
                                        <td>{{$customer->pay_amount}}
                                        </td>
                                        <td>{{$customer->getBillinfBy->name ?? "N/A"}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @if($customerPaymentDetails->isNotEmpty())
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">Total:</td>
                                        <td>{{$totalpay}} Taka</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function discounts(e) {
        let amount = "{{$data->getCustomer->bill_amount}}";
        if (Number(amount) < e) {
            return $('.discounts_val').val('');
        }
        let total = amount - e;
        document.getElementById('service_amount').value = total;
    }

    function payMonth() {
        let due = $('#paymentMonth option:selected').attr('dueamount');
        $('.dueInpute').val(due);
    }

    function payType(e) {
        if (e == "full_pay") {
            $(".payMonth").hide();
            $(".payAmount").hide();
            $(".discountfile").hide();
            $(".extendDate").hide();
        } else if (e == "partial") {
            $(".payMonth").show();
            $(".payAmount").show();
            $(".discountfile").show();
            $(".extendDate").show();

        }
    }
</script>
@endpush
