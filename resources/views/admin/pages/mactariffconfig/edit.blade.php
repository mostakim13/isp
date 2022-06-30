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
                                <label for="">TARIFF NAME</label>
                                <input type="text" class="form-control"
                                    value="{{ old('tariff_name') ?? $editinfo->tariff_name}}" name="tariff_name">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">PACKAGE NAME</label>
                                <select name="package_id" class="form-control">
                                    <option selected disabled>Select Option</option>
                                    @foreach($macpackages as $macpackage)
                                    <option {{ $editinfo->package_id == $macpackage->id ? "selected":""}}
                                        value="{{$macpackage->id}}">{{$macpackage->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">PACKAGE RATE</label>
                                <input type="text" class="form-control"
                                    value="{{ old('package_rate') ?? $editinfo->package_rate}}" name="package_rate">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">PACKAGE VALIDITY DAYS</label>
                                <input type="text" class="form-control" value="{{$editinfo->package_validation_day}}"
                                    name="package_validation_day">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">PACKAGE MINIMUM ACTIVATION DAYS</label>
                                <input type="text" class="form-control"
                                    value="{{$editinfo->package_minimum_activation_day}}"
                                    name="package_minimum_activation_day">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">SERVER NAME</label>
                                <select name="server_id" class="form-control">
                                    <option selected disabled>Select Option</option>
                                    <option {{ $editinfo->server_id == '1' ? "selected":""}} value="1">Mikrotik
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">PROTOCOL TYPE</label>
                                <select name="protocole_type" class="form-control">
                                    <option selected disabled>Select Option</option>
                                    <option {{ $editinfo->protocole_type == '1' ? "selected":""}}
                                        value="1">PPPOE</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">PROFILE (SPEED)</label>
                                <select name="ppp_profile" class="form-control">
                                    <option selected disabled>Select Option</option>
                                    @foreach($mpppprofiles as $mpppprofile)
                                    <option {{ $editinfo->protocole_type == $mpppprofile->id ? "selected":""}}
                                        value="{{$mpppprofile->id}}">{{$mpppprofile->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-1 form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
