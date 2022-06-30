@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Edit'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Customer</label>
                                <select class="form-control select2" id="single-select" name="customer_id">
                                    <option disabled selected>Select Customer</option>
                                    @foreach($customers as $key=>$value)
                                    <option {{$editinfo->customer_id ==$value->id ? "selected" : ''}}
                                        value="{{$value->id}}" >{{$value->username}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Package</label>
                                <select class="form-control select2" id="single-select" name="package_id">
                                    <option disabled selected>Select Package</option>
                                    @foreach($packages as $key=>$value)
                                    <option {{ $editinfo->package_id==$value->id ? "selected" : ''}}
                                        value="{{$value->id}}" >{{$value->name}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Date</label>
                                <input type="date" class="form-control input-rounded" name="date"
                                    value="{{$editinfo->date}}" placeholder="Date">
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
