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
                        <div class="card">
                            <div class="info-head card-title">
                                <h3><i class="fa fa-user-circle" aria-hidden="true"></i> Personal Information</h3>
                            </div>
                            <div class="info-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="ContactPerson">Contact Person Name <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-3" value="{{$editinfo->person_name}}"
                                                name="person_name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Email">Email Address <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-3" value="{{$editinfo->email}}" name="email"
                                                type="email">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="MobileNumber">Mobile No. <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-3" value="{{$editinfo->mobile}}" name="mobile"
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="PhoneNumber">Phone No.</label>
                                            <input class="form-control mb-3" value="{{$editinfo->phone}}" name="phone"
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="NationalId">National ID</label>
                                            <input class="form-control mb-3" value="{{$editinfo->national_id}}"
                                                name="national_id" type="text">
                                            <span id="spnNationalIdTxt" class="text-danger"
                                                style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Zone">Zone <span style="color: #f90000;">✱</span></label>
                                            <select class="form-control mb-3" name="zone_id">
                                                <option value="0" disabled selected>Select</option>
                                                @foreach($zones as $zone)
                                                <option {{$editinfo->zone_id == $zone->id ? "selected":""}}
                                                    value="{{$zone->id}}">{{$zone->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Address">Reseller Code <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-3" readonly
                                                value="{{ $editinfo->reseller_code }}" name="reseller_code" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="s">Reseller Prefix <span style="color: #f90000;">✱</span>
                                                &nbsp;</label>
                                            <input class="form-control mb-3" value="{{$editinfo->reseller_prefix}}"
                                                name="reseller_prefix" placeholder="Ex: AB1" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Address">Set Prefix In Mikrotik UserName? &nbsp;</label>
                                            <select class="form-control mb-3" name="set_prefix_mikrotikuser">
                                                <option disabled selected>Select</option>
                                                <option {{$editinfo->set_prefix_mikrotikuser == "yes" ? "selected":""}}
                                                    value="yes">Yes, I Want</option>
                                                <option {{$editinfo->set_prefix_mikrotikuser == "no" ? "selected":""}}
                                                    value="no">No, I
                                                    Don't </option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Address">Reseller Type <span style="color: #f90000;">✱</span>
                                            </label>
                                            <select class="form-control mb-3" name="reseller_type">
                                                <option disabled selected>Select</option>
                                                <option {{$editinfo->reseller_type == "Postpaid" ? "selected":""}}
                                                    value="Postpaid">Postpaid</option>
                                                <option {{$editinfo->reseller_type == "Prepaid" ? "selected":""}}
                                                    selected="selected" value="Prepaid">Prepaid</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Address">Minimum Rechargeable Amount <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-3" value="{{$editinfo->rechargeable_amount}}"
                                                name="rechargeable_amount" type="number">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Address">Address <span style="color: #f90000;">✱</span></label>
                                            <textarea class="form-control mb-3" cols="20" name="address" rows="1">
                                            {{$editinfo->rechargeable_amount}}
                                        </textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="file">Reseller Logo</label><br>
                                            <input class="form-control" name="reseller_logo" type="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="info-head">
                                <h3>
                                    <i class="fa fa-briefcase" aria-hidden="true"></i> Business &amp; Login Information
                                </h3>
                            </div>
                            <div class="info-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="ResellerName">Reseller <b>/</b> Business Name <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-3" value="{{$editinfo->business_name}}"
                                                name="business_name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="TariffId">Tariff Name <span
                                                    style="color: #f90000;">✱</span></label>
                                            <select class="form-control mb-3" name="tariff_id">
                                                <option value="0" disabled selected>Select</option>
                                                @foreach($Mactariffs as $Mactariff)
                                                <option {{$editinfo->tariff_id == $Mactariff->tariff_name ?
                                                    "selected":""}}>
                                                    {{$Mactariff->tariff_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="user_roll">User Roll<span style="color: #f90000;">✱</span>
                                            </label>
                                            <select class="form-control mb-3" name="user_roll">
                                                <option disabled selected>Select</option>
                                                @foreach($userRolls as $userRoll)
                                                <option {{$editinfo->getUser->roll_id == $userRoll->id ?
                                                    "selected":""}} value="{{$userRoll->id}}">{{$userRoll->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="UserName">User Name <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-3" value="{{$editinfo->user_name}}"
                                                name="user_name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="NationalId">Password <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-3" name="password" type="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="NationalId">Confirm Password <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input autocomplete="off" class="form-control mb-3"
                                                name="password_confirmation" type="password">
                                        </div>
                                    </div>
                                </div>
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
