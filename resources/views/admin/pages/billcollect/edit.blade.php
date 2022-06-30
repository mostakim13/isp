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

                        <h3>Mikrotik Require <span class="text-danger">*</span></h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Name</label>
                                <input type="text" class="form-control input-rounded" name="name"
                                    value="{{ $editinfo->name }}">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Service</label>
                                <select name="service" class="form-control">
                                    <option disabled>Select Service</option>
                                    <option selected value="pppoe">pppoe</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Caller</label>
                                <input type="text" class="form-control input-rounded" name="caller"
                                    value="{{ $editinfo->caller }}">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Profile</label>
                                <select name="profile" class="form-control">
                                    <option disabled>Select Profile</option>
                                    @foreach($mpppprofiles as $value)
                                    <option {{$editinfo->profile == $value->mid ? "selected":""}}
                                        value="{{$value->mid}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Routes</label>
                                <input type="text" class="form-control input-rounded" name="routes"
                                    value="{{ $editinfo->routes }}">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Comment</label>
                                <input type="text" class="form-control input-rounded" name="comment"
                                    value="{{ $editinfo->comment }}">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Password</label>
                                <input type="password" class="form-control input-rounded" name="password">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Confirm Password</label>
                                <input type="password" class="form-control input-rounded" name="password_confirmation">
                            </div>
                        </div>
                        <h3 class="mb3">Generale</h3>
                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Ipv6 Routes</label>
                                <input type="number" class="form-control input-rounded" name="ipv6_routes"
                                    value="{{ $editinfo->ipv6_routes }}">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Limit Bytes In</label>
                                <input type="number" class="form-control input-rounded" name="limit_bytes_in"
                                    value="{{ $editinfo->limit_bytes_in }}">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Limit Bytes out</label>
                                <input type="number" class="form-control input-rounded" name="limit_bytes_out"
                                    value="{{ $editinfo->limit_bytes_out }}">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Disabled</label>
                                <select name="disabled" class="form-control">
                                    <option {{$editinfo->disabled == 'true'? "selected":"" }} value="true">True</option>
                                    <option {{$editinfo->disabled == 'false'? "selected":"" }} value="false">False
                                    </option>
                                </select>
                            </div>
                        </div>

                        <h3>Customer Details</h3>

                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">User Name</label>
                                <input type="text" class="form-control input-rounded" name="username"
                                    value="{{ old('username') ?? ($user->username ?? '')}}" placeholder="Username">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Email</label>
                                <input type="email" class="form-control input-rounded" name="email"
                                    value="{{ old('email') ?? ($user->email ?? '')}}" placeholder="Email">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Phone</label>
                                <input type="text" class="form-control input-rounded" name="phone"
                                    value="{{ old('phone') ?? ($user->phone ?? '')}}" placeholder="Phone">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Zone</label>

                                <div class="input-group mb-1">
                                    <button class="btn btn-primary" type="button">Zone</button>
                                    <select name="zone_id" value="{{ old('zone_id') ?? ($editinfouser->zone_id ?? '')}}"
                                        class="default-select form-control wide">
                                        <option selected="" disabled>-- Select Zone --</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Billing Person</label>
                                <select name="billing_person"
                                    value="{{ old('billing_person') ?? ($editinfouser->billing_person ?? '')}}"
                                    id="billing_person" class="form-control input-rounded">
                                    <option value="">-- Select Billing Person --</option>
                                    <option value="1">Rabbi</option>
                                    <option value="2">Abir</option>
                                    <option value="3">Joy</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Package</label>
                                <div class="input-group mb-1">
                                    <button class="btn btn-primary" type="button">Package</button>
                                    <select name="package" value="{{ old('package') ?? ($editinfouser->package ?? '')}}"
                                        class="default-select form-control wide">
                                        <option selected="" disabled>-- Select Package --</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Father Name</label>
                                <input type="text" class="form-control input-rounded" name="father_name"
                                    value="{{ old('father_name') ?? ($editinfouser->father_name ?? '')}}"
                                    placeholder="Father Name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Mother Name</label>
                                <input type="text" class="form-control input-rounded" name="mother_name"
                                    value="{{ old('mother_name') ?? ($editinfouser->mother_name ?? '')}}"
                                    placeholder="Mother Name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Spouse Name</label>
                                <input type="text" class="form-control input-rounded" name="spouse_name"
                                    value="{{ old('spouse_name') ?? ($editinfouser->spouse_name ?? '')}}"
                                    placeholder="Spouse Name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Nid</label>
                                <input type="text" class="form-control input-rounded" name="nid"
                                    value="{{ old('nid') ?? ($editinfouser->nid ?? '')}}" placeholder="Nid">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Doc Image</label>
                                <div class="input-group mb-1">
                                    <button class="btn btn-primary btn-sm" type="button">Doc Image</button>
                                    <div class="form-file">
                                        <input type="file" name="doc_image"
                                            value="{{ old('doc_image') ?? ($editinfouser->doc_image ?? '')}}"
                                            class="form-file-input form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Date Of Birth</label>

                                <div class="input-group mb-1">
                                    <button class="btn btn-primary btn-sm" type="button">Date Of Birth</button>
                                    <div class="form-file">
                                        <input type="date" name="dob"
                                            value="{{ old('dob') ?? ($editinfouser->dob ?? '')}}"
                                            class="form-file-input form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Reference</label>
                                <input type="text" class="form-control input-rounded" name="reference"
                                    value="{{ old('reference') ?? ($editinfouser->reference ?? '')}}"
                                    placeholder="Reference">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">User Type</label>
                                <input type="text" class="form-control input-rounded" name="user_type"
                                    value="{{ old('user_type') ?? ($editinfouser->user_type ?? '')}}"
                                    placeholder="User Type">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Mac Address</label>
                                <input type="text" class="form-control input-rounded" name="mac_address"
                                    value="{{ old('mac_address') ?? ($editinfouser->mac_address ?? '')}}"
                                    placeholder="Mac Address">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Address</label>
                                <input type="text" class="form-control input-rounded" name="address"
                                    value="{{ old('address') ?? ($editinfouser->address ?? '')}}" placeholder="Address">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Connection Date</label>
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Connection Date</span>
                                    <input name="connection_date"
                                        value="{{ old('connection_date') ?? ($editinfouser->connection_date ?? '')}}"
                                        type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Bill Amount</label>
                                <input type="text" class="form-control input-rounded" name="bill_amount"
                                    value="{{ old('bill_amount') ?? ($editinfouser->bill_amount ?? '')}}"
                                    placeholder="Bill Amount">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Speed</label>
                                <input type="text" class="form-control input-rounded" name="speed"
                                    value="{{ old('speed') ?? ($editinfouser->speed ?? '')}}" placeholder="Speed">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">IP Address</label>
                                <input type="text" class="form-control input-rounded" name="ip_address"
                                    value="{{ old('ip_address') ?? ($editinfouser->ip_address ?? '') }}"
                                    placeholder="Ip Address">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Limit</label>
                                <input type="text" class="form-control input-rounded" name="limit"
                                    value="{{ old('limit') ??  ($editinfouser->limit ?? '') }}" placeholder="limit">
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
