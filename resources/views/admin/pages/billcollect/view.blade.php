@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Collected Bill'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <div class="basic-form">
                    <div class="col-lg-12">
                        <h4 class="card-title">{{$billcollected->name}}({{$billcollected->username}}) Payment Details
                        </h4>

                        <div class="table-responsive">
                            <table class="table table-bordered table-responsive-sm">
                                <thead class="thead-primary">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Bill Generate Date</th>
                                        <th scope="col">Month</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Pay</th>
                                        <th scope="col">Billing By</th>
                                    </tr>
                                </thead>
                                @if($customerPaymentDetails)
                                <tbody>
                                    @php
                                    $totalpay = 0;
                                    @endphp
                                    @if($customerPaymentDetails->isEmpty())
                                    <tr>
                                        <td colspan="9" class="text-center">No Data Found</td>
                                    </tr>
                                    @else
                                    @foreach($customerPaymentDetails as $key=>$customer)
                                    @php
                                    $totalpay += $customer->pay_amount;
                                    @endphp
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{Carbon\Carbon::parse($customer->updated_at)->format('d,M,Y')}}</td>
                                        <td>{{Carbon\Carbon::parse($customer->date_)->format('F-Y')}}</td>
                                        <td>{{ $customer->PaymentMethod->name ?? "N/A" }}</td>
                                        <td>{!! $customer->description !!}</td>
                                        <td>{{ $customer->discount }}</td>
                                        <td>{{$customer->customer_billing_amount}}
                                        <td>{{$customer->pay_amount ?? 0}}
                                        </td>
                                        </td>
                                        <td>{{$customer->getBillinfBy->name ?? "N/A"}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                @endif
                                @if($customerPaymentDetails->isNotEmpty())
                                <tfoot>
                                    <tr>
                                        <td colspan="8" class="text-right">{{$totalpay}} Taka</td>
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
