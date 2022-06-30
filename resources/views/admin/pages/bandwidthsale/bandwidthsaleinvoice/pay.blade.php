@extends('admin.master')

@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Record A Payment'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ route('bandwidthsaleinvoice.paystore',$banseidthsaleinvoice->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <label for="">Payment Date</label>
                                <input type="date" class="form-control" value="{{ old('date_')}}" name="date_">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Pay Amount</label>
                                <input type="text" class="form-control" value="{{ old('amount')}}" name="amount">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Discount</label>
                                <input type="text" class="form-control" value="{{ old('discount')}}" name="discount">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Payment Method</label>
                                <select name="payment_method" class="form-control" id="">
                                    <option disabled selected>Select</option>
                                    @foreach($paymentmethods as $paymentmethod)
                                    <option value="{{$paymentmethod->id}}">{{$paymentmethod->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Paid by</label>
                                <input type="text" class="form-control" value="{{ old('paid_by')}}" name="paid_by">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" id="" cols="30" rows="10">

                                </textarea>
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
