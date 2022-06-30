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
                            <div class="col-md-4 mb-1">
                                <label for=""> Customer <span class="text-danger">*</span></label>
                                <select name="customer_id" class="form-control" id="">
                                    <option selected disabled>Select Customer</option>
                                    @foreach($customers as $customer)
                                    <option {{old('customer_id')==$customer->id ? "selected":""}}
                                        value="{{$customer->id}}">{{$customer->name}}-{{$customer->username}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for=""> Billing Person <span class="text-danger">*</span></label>
                                <select name="biller_name" class="form-control" id="">
                                    <option selected disabled>Select User</option>
                                    @foreach($users as $user)
                                    <option {{old('biller_name')==$user->id ? "selected":""}}
                                        value="{{$user->id}}">{{$user->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-1 ">
                                <label for="">Payment Method</label>
                                <select name="payment_method_id" class="form-control">
                                    <option selected disabled>Select Method</option>
                                    @foreach($paymentMethods as $payment)
                                    <option {{old('payment_method_id')==$payment->id ? "selected":""}}
                                        value="{{$payment->id}}">
                                        {{$payment->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label>Billing Date</label>
                                <input type="month" class="form-control" value="{{old('date_')}}" name="date_">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label>Billing Amount</label>
                                <input type="number" class="form-control" value="{{old('customer_billing_amount')}}"
                                    name="customer_billing_amount">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label>Paid amount</label>
                                <input type="number" class="form-control" value="{{old('pay_amount')}}"
                                    name="pay_amount">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label>Due amount</label>
                                <input type="number" class="form-control" value="{{old('partial')}}" name="partial">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label>Discount amount</label>
                                <input type="number" value="{{old('discount')}}" class="form-control" name="discount">
                            </div>
                            <div class="col-md-4 mb-1 ">
                                <label for="">Status</label>
                                <select name="status" class="form-control">
                                    <option selected disabled>Select Status</option>
                                    <option {{old('status')=="paid" ? "selected" :""}} value="paid">Paid
                                    </option>
                                    <option {{old('status')=="unpaid" ? "selected" :""}} value="unpaid">Unpaid</option>
                                    <option {{old('status')=="partial" ? "selected" :""}} value="partial">Due</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-1">
                                <label>Description</label>
                                <textarea name="description" class="form-control">
                                    {{old('description')}}
                                </textarea>
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
