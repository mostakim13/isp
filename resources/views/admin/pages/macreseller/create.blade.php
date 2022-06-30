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
                                            <input class="form-control mb-1" name="person_name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Email">Email Address <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-1" name="email" type="email">
                                            <span id="spnEmailTxt" class="text-danger" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="MobileNumber">Mobile No. <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-1" name="mobile" type="text">
                                            <span id="spnMobileNumberTxt" class="text-danger"
                                                style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="PhoneNumber">Phone No.</label>
                                            <input class="form-control mb-1" name="phone" type="text">

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="NationalId">National ID</label>
                                            <input class="form-control mb-1" name="national_id" type="text">
                                            <span id="spnNationalIdTxt" class="text-danger"
                                                style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Zone">Zone <span style="color: #f90000;">✱</span></label>
                                            <select class="form-control mb-1" name="zone_id">
                                                <option value="0" disabled selected>Select</option>
                                                @foreach($zones as $zone)
                                                <option value="{{$zone->id}}">{{$zone->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Address">Reseller Code <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-1" readonly value="{{ $reselercode }}"
                                                name="reseller_code" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="s">Reseller Prefix <span style="color: #f90000;">✱</span>
                                                &nbsp;</label>
                                            <input class="form-control mb-1" name="reseller_prefix"
                                                placeholder="Ex: AB1" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Address">Set Prefix In Mikrotik UserName? &nbsp;</label>
                                            <select class="form-control mb-1" name="set_prefix_mikrotikuser">
                                                <option disabled selected>Select</option>
                                                <option value="yes">Yes, I Want</option>
                                                <option selected value="no">No, I Don't </option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Address">Reseller Type <span style="color: #f90000;">✱</span>
                                            </label>
                                            <select class="form-control mb-1" id="reseller_type"
                                                onchange="checkResellerType()" name="reseller_type">
                                                <option disabled selected>Select</option>
                                                <option value="postpaid">Postpaid</option>
                                                <option selected="selected" value="prepaid">Prepaid</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Address">Minimum Rechargeable Amount <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-1" name="rechargeable_amount" type="number">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Address">Address <span style="color: #f90000;">✱</span></label>
                                            <textarea class="form-control mb-1" cols="20" name="address"
                                                rows="1"></textarea>
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
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="ResellerName">Reseller <b>/</b> Business Name <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-1" name="business_name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="TariffId">Tariff Name <span
                                                    style="color: #f90000;">✱</span></label>
                                            <select class="form-control mb-1" name="tariff_id">
                                                <option value="0" disabled selected>Select</option>
                                                @foreach($Mactariffs as $Mactariff)
                                                <option value="{{$Mactariff->id}}">{{$Mactariff->tariff_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="TariffId">Want To Disabled Clients?<span
                                                    style="color: #f90000;">✱</span></label>
                                            <select class="form-control mb-1" id="disabled_client"
                                                name="disabled_client">
                                                <option value>Select</option>
                                                <option value="true">Yes, I Want</option>
                                                <option value="false">No, I Don't </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="UserName">Minimum Balance<span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-1" name="minimum_balance" id="minimum_balance"
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="user_roll">User Role<span style="color: #f90000;">✱</span>
                                            </label>
                                            <select class="form-control mb-1" name="user_roll">
                                                <option disabled selected>Select</option>
                                                @foreach($userRolls as $userRoll)
                                                <option value="{{$userRoll->id}}">{{$userRoll->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="UserName">User Name <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-1" name="user_name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="NationalId">Password <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input class="form-control mb-1" name="password" type="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="NationalId">Confirm Password <span
                                                    style="color: #f90000;">✱</span></label>
                                            <input autocomplete="off" class="form-control mb-1"
                                                name="password_confirmation" type="password">
                                        </div>
                                    </div>
                                </div>
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

@section('scripts')
<script>
    function checkResellerType() {
        let value = $('#reseller_type option:selected').val();
        if (value === 'postpaid') {
            $('#disabled_client').attr('disabled', false);
            $('#minimum_balance').attr('readonly', false);
        } else if (value === 'prepaid') {
            $('#disabled_client').attr('disabled', true);
            $('#minimum_balance').attr('readonly', true);
        }
    }
    checkResellerType();
</script>
@endsection
