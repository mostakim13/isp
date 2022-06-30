@extends('admin.master')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h4 class="card-title">{{$page_heading ?? 'List'}}</h4>

                <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-info text-right">
                    <span class="btn-icon-start text-info">
                        <i class="fa fa-plus color-info"></i>
                    </span>
                    Add
                </a>

            </div>
            <div class="card-body">
                <x-alert></x-alert>
                <div class="table-responsive">
                    <table id="general_data_tables" class="table table-striped table-responsive-sm">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Customer</th>
                                <th>Contact Person</th>
                                <th>Bill No</th>
                                <th>Invoice of Month</th>
                                <th>Total Amount</th>
                                <th>Received Amount</th>
                                <th>Discount</th>
                                <th>Due</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bandwidthsales as $key => $bandwidthsale)
                            <tr>
                                <th>{{$key+1}}</th>
                                <th>{{$bandwidthsale->customer->name}}</th>
                                <th>{{$bandwidthsale->contact_person ?? "N/A"}}</th>
                                <th>{{$bandwidthsale->invoice_no ?? "N/A"}}</th>
                                <th>{{$bandwidthsale->billing_month ?? "N/A"}}</th>
                                <th>{{$bandwidthsale->total ?? "00"}}</th>
                                <th>{{$bandwidthsale->received_amount ?? "00"}}</th>
                                <th>{{$bandwidthsale->discount ?? "00"}}</th>
                                <th>{{$bandwidthsale->due ?? "00"}}</th>
                                <th>
                                    @if($bandwidthsale->status == "due")
                                    <a href="{{route('bandwidthsaleinvoice.pay',$bandwidthsale->id)}}"
                                        class="btn btn-success btn-xxs">Pay</a>
                                    <button class="btn btn-danger btn-xxs">Due</button>
                                    @elseif($bandwidthsale->status == "paid")
                                    <button class="btn btn-primary btn-xxs">Paid</button>
                                    @endif
                                </th>
                                <th>
                                    <a href="{{route('bandwidthsaleinvoice.edit',$bandwidthsale->id)}}"
                                        class="btn btn-info">Edit</a>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
