@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title ">{{$page_heading ?? 'Create'}}
                    <x-loading></x-loading>
                </h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-1 col-md-12 col-sm-12 col-xs-12">
                                <label>User Name</label><br>
                                <select name="client_id" id="single-select" onchange="userDetails(this.value)"
                                    class="client_id form-control">
                                    <option disabled selected>Select</option>
                                    @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}}({{$customer->username}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-1 col-md-3 col-sm-6 col-xs-12">
                                <label>Customer Name</label><br>
                                <input id="cClientname" class="form-control form-padding bg-gray" readonly="">
                            </div>
                            <div class="form-group mb-1 col-md-3 col-sm-6 col-xs-12">
                                <label>Mobile Number (Existing)</label><br>
                                <input id="mobile" class="form-control form-padding bg-gray" readonly="">
                            </div>
                            <div class="form-group mb-1 col-md-3 col-sm-6 col-xs-12">
                                <label>Client Address</label><br>
                                <input id="cClientaddress" class="form-control form-padding bg-gray" readonly="">
                            </div>
                            <div class="form-group mb-1 col-md-3 col-sm-6 col-xs-12">
                                <label>Service</label><br>
                                <input id="cService" class="form-control form-padding bg-gray" readonly="">
                            </div>
                            <div class="form-group mb-1 col-md-3 col-sm-6 col-xs-12">
                                <label>Zone</label><br>
                                <input id="zone" class="form-control form-padding bg-gray" readonly="">
                            </div>
                            <div class="form-group mb-1 col-sm-2">
                                <label>Monthly Bill</label>
                                <input class="form-control form-padding bg-gray" id="MonthlyBill" type="text"
                                    readonly="">
                            </div>
                            <div class="form-group mb-1 col-sm-3">
                                <label>Due Amount</label><br>
                                <input id="dueamount" class="form-control form-padding bg-gray" readonly="">
                                <span class="led-green"></span>
                            </div>
                            <div class="form-group mb-1 col-sm-2">
                                <label>Mikrotik Status</label><br>
                                <span id="MikrotikStatus" class=" form-padding "></span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group mb-1 col-md-3 col-sm-6 col-xs-12">
                                <label>Uptime</label><br>
                                <input id="clSupportUptime" class="form-control form-padding bg-gray" readonly="">
                            </div>
                            <div class="form-group mb-1 col-md-3 col-sm-6 col-xs-12">
                                <label>Last Logout Time</label><br>
                                <input id="clSupportLogoutTime" class="form-control bg-gray" readonly="">
                            </div>
                            <div class="form-group mb-1 col-md-3 col-sm-6 col-xs-12">
                                <label>Mac Address/Caller Id</label><br>
                                <input id="clSupportMac" class="form-control form-padding bg-gray" readonly="">
                            </div>
                            <div class="form-group mb-1 col-md-3 col-sm-6 col-xs-12">
                                <label>IP Address</label><br>
                                <input id="clSupportIp" class="form-control form-padding bg-gray" readonly="">
                            </div>

                            <div class="form-group mb-1 col-md-6 col-sm-6 col-xs-12 padding-0">
                                <div class="form-group mb-1 col-sm-4">
                                    <label>&nbsp;</label><br>
                                    <span id="onlineStatus">Not Found</span>
                                </div>
                                <div class="form-group mb-1 col-sm-4 dummy_download_data_amount" style="display:none;">
                                    <label>Downloaded Data</label>
                                    <input type="text"
                                        class="form-control form-padding bg-gray dummy_spn_downloaded_data_amount"
                                        value="" readonly="">
                                </div>
                                <div class="form-group mb-1 col-sm-4 dummy_upload_data_amount" style="display:none;">
                                    <label>Uploaded Data</label>
                                    <input type="text"
                                        class="form-control form-padding bg-gray dummy_spn_uploaded_data_amount"
                                        value="" readonly="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group mb-1 col-md-3 col-sm-4 col-xs-12">
                                    <label>Problem Category</label><br>
                                    <select name="problem_category" class="form-control">
                                        <option disabled selected>Select</option>
                                        @foreach($supportCategorys as $supportCategory)
                                        <option value="{{$supportCategory->id}}">{{$supportCategory->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-1 col-md-3 col-sm-4 col-xs-12">
                                    <label>Problem Priority</label><br>
                                    <select name="priority" class="form-control">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                                <div class="form-group mb-1 col-md-3 col-sm-4 col-xs-12">
                                    <label>Assign To</label><br>
                                    <select name="assign_to" class="form-control">
                                        <option disabled selected>Select</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" form-group mb-1 col-sm-4 col-md-3">
                                    <label>Complained Number</label>
                                    <input type="text" name="complain_number" class="form-control  bg-gray ">
                                </div>
                                <div class="form-group mb-1 col-sm-4 col-md-3">
                                    <label>Attachments</label>
                                    <input type="file" name="attachments" class="form-control bg-gray ">
                                </div>
                                <div class="form-group mb-1 col-sm-12 col-md-12">
                                    <label>Remarks/Note/Comments</label></br>
                                    <textarea name="note" id="ckeditor" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
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
    function userDetails(e) {
        $.ajax({
            "url": "{{route('supportticket.userdetails')}}",
            method: "get",
            data: {
                'userid': e,
            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                $('#loading').hide();
                $('#cClientname').val(data.name);
                $('#mobile').val(data.phone);
                $('#cClientaddress').val(data.address);
                $('#MonthlyBill').val(data.bill_amount);
                $('#dueamount').val("Due:( " + data.due + ")");
                $('#MikrotikStatus').html("<a  class='btn btn-md btn-square btn-success'>Active</a>");
                $('#cService').val(data.service);
                $('#clSupportMac').val(data.mac_address);
                $('#clSupportIp').val(data.ip_address);
                $('#clSupportIp').val(data.ip_address);
                $('#onlineStatus').html("<a  class='btn btn-md  btn-square btn-danger'>Offline</a>");
                console.log(data);
            }
        })
    }
</script>
@endsection
