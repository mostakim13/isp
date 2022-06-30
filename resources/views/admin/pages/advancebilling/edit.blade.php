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
                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <label for=""> Customer <span class="text-danger">*</span></label>
                                <select name="customer_id" class="form-control select2" id="">
                                    <option selected disabled>Select Customer</option>
                                    @foreach($customers as $customer)
                                    <option {{$editinfo->customer_id==$customer->id ? "selected":""}}
                                        value="{{$customer->id}}">{{$customer->name}}-{{$customer->username}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label>Advance Billing Amount</label>
                                <input type="number" class="form-control" value="{{$editinfo->advanced_payment}}"
                                    name="advanced_payment" placeholder="0">
                            </div>

                            <div class="col-md-4 mb-1">
                                <label>Advance Billing Date</label>
                                <input type="date" class="form-control" value="{{$editinfo->date}}" name="date">
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
