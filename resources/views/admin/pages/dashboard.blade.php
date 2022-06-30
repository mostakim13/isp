@extends('admin.master')

@section('title')
Dashboard
@endsection

@section('style')
<link href="{{asset('admin_assets/vendor/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('admin_assets/vendor/nouislider/nouislider.min.css')}}">
<style>
    .card_color{
background-color: #10245A;
border-radius: 30px;
color:#fff;
    }
    .h3_title{
color:#fff;
    }

</style>
@endsection
@section('content')
<!-- Stats Horizontal Card -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$customers}}</h3>
                    <p class="card-text">All Clients</p>
                </div>
                <div class="avatar bg-light-primary p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="cpu" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$active_customers}}</h3>
                    <p class="card-text">All Active Clients</p>
                </div>
                <div class="avatar bg-light-success p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="server" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$inactive_customers}}</h3>
                    <p class="card-text">All Inactive Clients</p>
                </div>
                <div class="avatar bg-light-danger p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="activity" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$new_customers}}</h3>
                    <p class="card-text">New Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$todays_billings}}</h3>
                    <p class="card-text">Today's Collected Bill</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$total_billings}}</h3>
                    <p class="card-text">Total Collected Bill</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$total_due}}</h3>
                    <p class="card-text">Total Due</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$customers}}</h3>
                    <p class="card-text">Billing Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$paid_customers}}</h3>
                    <p class="card-text">Paid Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$partial_customers}}</h3>
                    <p class="card-text">Partially Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$total_unpaids}}</h3>
                    <p class="card-text">Unpaid Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$suppliers}}</h3>
                    <p class="card-text">All Suppliers</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$products}}</h3>
                    <p class="card-text">All Products</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$macsallers}}</h3>
                    <p class="card-text">All Mac Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{$bandwith_clients}}</h3>
                    <p class="card-text">All Bandwidth Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">2</h3>
                    <p class="card-text">VIP Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">Left Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">Active Mac Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">2</h3>
                    <p class="card-text">Disabled Mac Clients</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">Discount</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">Monthly Bill</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">Installation Charge</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">Expense</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">Paid Salary</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">SMS Balance</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">Mac Reseller Fund</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">Bandwidth Reseller Bill</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card_color">
            <div class="card-header">
                <div>
                    <h3 class="font-weight-bolder mb-0 h3_title">0</h3>
                    <p class="card-text">Bandwidth Upstream Bill</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="alert-octagon" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Today Bill Collection</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Customer Phone</th>
                                <th scope="col">Bill Collect</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($billings as $key=>$billing)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$billing->getCustomer->name ?? "N/A"}}</td>
                                <td>{{$billing->getCustomer->phone ?? "N/A"}}</td>
                                <td>{{$billing->getBillinfBy->Name ?? "N/A"}}</td>
                                <td>{{$billing->customer_billing_amount ?? "N/A"}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Stats Horizontal Card -->
{{-- <div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">All Clients</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$customers}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Active Clients</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$active_customers}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Inactive Clients</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$inactive_customers}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">New Clients</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$new_customers}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Todays Bill</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$todays_billings}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Total Bill</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$total_billings}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Total Due</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$total_due}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Billing Clients</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$customers}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Paid Clients</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$paid_customers}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Partially Clients</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$partial_customers}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Unpaid Clients</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$total_unpaids}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Total Supplier</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$suppliers}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Total Product</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$products}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Total Mac Resaller</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$macsallers}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-body d-flex p-2 justify-content-between card_color">
                                            <div>
                                                <h4 class="fs-18 font-w600 text-nowrap">Total Bandwidth Client</h4>
                                                <div class="d-flex align-items-center">
                                                    <h3 class="fs-32 font-w700 mb-0">{{$bandwith_clients}}</h3>
                                                    <span class="d-block ms-4">
                                                        <svg width="21" height="11" viewbox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                fill="#09BD3C"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Today Bill Collection</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Sl</th>
                                                        <th scope="col">Customer Name</th>
                                                        <th scope="col">Customer Phone</th>
                                                        <th scope="col">Bill Collect</th>
                                                        <th scope="col">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($billings as $key=>$billing)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$billing->getCustomer->name ?? "N/A"}}</td>
                                                        <td>{{$billing->getCustomer->phone ?? "N/A"}}</td>
                                                        <td>{{$billing->getBillinfBy->Name ?? "N/A"}}</td>
                                                        <td>{{$billing->customer_billing_amount ?? "N/A"}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div> --}}
@endsection

@section('chartsctipts')
<script src="{{ asset('admin_assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ asset('admin_assets/vendor/apexchart/apexchart.js') }}"></script>

<script src="{{ asset('admin_assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>

<!-- Chart piety plugin files -->
<script src="{{ asset('admin_assets/vendor/peity/jquery.peity.min.js') }}"></script>
<!-- Dashboard 1 -->
<script src="{{ asset('admin_assets/js/dashboard/dashboard-1.js') }}"></script>

<script src="{{ asset('admin_assets/vendor/owl-carousel/owl.carousel.js') }}"></script>

@endsection
