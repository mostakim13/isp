@extends('admin.master')

@section('content')
<style>
    input.larger {
        width: 50px;
        height: 50px;
        text-align: center;
        padding-left: 0;

    }
</style>
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
                        <div>
                            <h4>Personal Information</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{$editinfo->name}}" placeholder="Name">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Gender</label>
                                <select class="form-control" id="single-select" name="gender">
                                    <option disabled selected>Select Gender</option>
                                    <option value="1" {{$editinfo->gender==1 ? 'selected':''}}>Male</option>
                                    <option value="2" {{$editinfo->gender==2 ? 'selected':''}}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Occupation</label>
                                <input type="text" class="form-control" name="occupation" value="{{$editinfo->occupation}}" placeholder="">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Date of Birth</label>
                                <input type="date" class="form-control" name="dateofbirth" value="{{$editinfo->dateofbirth}}" placeholder="">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Father Name</label>
                                <input type="text" class="form-control" name="father_name" value="{{$editinfo->father_name}}" placeholder="Father name">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Mother Name</label>
                                <input type="text" class="form-control" name="mother_name" value="{{$editinfo->mother_name}}" placeholder="Mother name">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">NID/Birth Certificate No</label>
                                <input type="text" class="form-control" name="nid" value="{{$editinfo->nid}}" placeholder="">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Registration Form No</label>
                                <input type="text" class="form-control" name="registrationformno" value="{{$editinfo->registrationformno}}" placeholder="">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Remarks</label>
                                <input type="text" class="form-control" name="remarks" value="{{$editinfo->remarks}}" placeholder="">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Profile Picture</label>
                                <input type="file" class="form-control" name="profile_picture" value="{{$editinfo->profile_picture}}" placeholder="">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">NID/Birth Certicate Picture</label>
                                <input type="file" class="form-control" name="nid_picture" value="{{$editinfo->nid_picture}}" placeholder="">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Registration Form Picture</label>
                                <input type="file" class="form-control" name="registrationformpicture" value="{{$editinfo->registrationformpicture}}" placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div>
                            <h4>Contact Information</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Mobile Number <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="mobilenumber" value="{{$editinfo->mobilenumber}}" placeholder="">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Phone Number</label>
                                <input type="number" class="form-control" name="phonenumber" value="{{$editinfo->phonenumber}}" placeholder="">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Email Address</label>
                                <input type="email" class="form-control" name="emailaddress" value="{{$editinfo->emailaddress}}" placeholder="">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Facebook Profile Link</label>
                                <input type="text" class="form-control" name="facebookprofilelink" value="{{$editinfo->facebookprofilelink}}" placeholder="">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Linkedin Profile Link</label>
                                <input type="text" class="form-control" name="linkedinprofilelink" value="{{$editinfo->linkedinprofilelink}}"
                                    placeholder="Father name">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">District</label>
                                <select class="form-control" id="single-select" name="district">
                                    <option disabled selected>Select district</option>
                                    @foreach ($districts as $district)
                                    <option value="{{$district->id}}" {{$editinfo->district==$district->id ? 'selected':''}}>{{$district->district_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Upazila/Thana</label>
                                <select class="form-control" id="single-select" name="upazila">
                                    <option disabled selected>Select upazila</option>
                                    @foreach ($upazilas as $upazila)
                                    <option value="{{$upazila->id}}" {{$editinfo->upazila==$upazila->id ? 'selected':''}}>{{$upazila->upozilla_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Road Number</label>
                                <input type="text" class="form-control" name="roadnumber" value="{{$editinfo->roadnumber}}" placeholder="">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">House Number</label>
                                <input type="text" class="form-control" name="housenumber" value="{{$editinfo->housenumber}}" placeholder="">
                            </div>
                            <div class="col-md-6 mb-1">

                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Present Address</label>
                                <textarea type="text" class="form-control" id="presentaddress" name="presentaddress"
                                    placeholder="">{!! $editinfo->presentaddress !!}</textarea>
                            </div>
                            <div class="col-md-4 mb-1 text-center">
                                <h3 for="">Same as present address?</h3>
                                <div class="">
                                    <input type="checkbox" class="larger" name="checkBox2" id="sameas">
                                </div>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Permanent Address</label>
                                <textarea type="text" class="form-control" name="permanentaddress" id="permanentaddress"
                                    placeholder="">{!! $editinfo->permanentaddress !!}</textarea>
                            </div>

                        </div>
                        <hr>
                        <div>
                            <h4>Network & Product Information</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Zone <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="single-select" name="zone">
                                    <option disabled selected>Select zone</option>
                                    @foreach ($zones as $zone)
                                    <option value="{{$zone->id}}" {{$editinfo->zone==$zone->id ? 'selected':''}}>{{$zone->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Sub Zone</label>
                                <select class="form-control select2" id="single-select" name="subzone">
                                    <option disabled selected>Select Subzone</option>
                                    @foreach ($subzones as $subzone)
                                    <option value="{{$subzone->id}}" {{$editinfo->subzone==$subzone->id ? 'selected':''}}>{{$subzone->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Connection Type <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="single-select" name="connectiontype">
                                    <option disabled selected>Select Type</option>
                                    @foreach ($connectiontypes as $connectiontype)
                                    <option value="{{$connectiontype->id}}"{{$editinfo->connectiontype==$connectiontype->id ? 'selected':''}}>{{$connectiontype->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Client Type <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="single-select" name="clienttype">
                                    <option disabled selected>Select Type</option>
                                    @foreach ($clienttypes as $clienttype)
                                    <option value="{{$clienttype->id}}" {{$editinfo->clienttype==$clienttype->id ? 'selected':''}}>{{$clienttype->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>

                        <div>
                            <h4>Service Information</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Package <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="single-select" onchange="profileId(this.value)" name="package_id">
                                    <option disabled selected>Select package</option>
                                    @foreach ($packages as $package)
                                    <option value="{{$package->id}}"{{$editinfo->package_id==$package->id?'selected':''}}>{{$package->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Billing Status <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="single-select" name="billingstatus">
                                    <option disabled selected>Select billing status</option>
                                    @foreach ($billingstatuses as $billingstatus)
                                    <option value="{{$billingstatus->id}}" {{$editinfo->billingstatus == $billingstatus->id?'selected':''}}>{{$billingstatus->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Monthly Bill <span class="text-danger">*</span></label>
                                <input type="text" class="form-control monthlybill" name="monthlybill" value="{{$editinfo->monthlybill}}">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Commited Billing Date</label>
                                <input type="date" class="form-control" name="commitedbilldate" value="{{$editinfo->commitedbilldate}}">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Reference By</label>
                                <input type="text" class="form-control" name="referenceby" value="{{$editinfo->referenceby}}">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Referral Contact</label>
                                <input type="text" class="form-control" name="referralcontact" value="{{$editinfo->referralcontact}}">
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
    $("#sameas").on('click',function(){
let same = $(this).is(':checked');
let presentaddress = $('#presentaddress');
let permanentaddress = $('#permanentaddress');
if(same){
   permanentaddress.val(presentaddress.val());
}else{
permanentaddress.val('');
}
    })

    function profileId(e) {
    $.ajax({
    url: "{{route('newconnection.monthlybill')}}",
    method: "GET",
    data: {
    id: e
    },
    success: function (data) {
    $('.monthlybill').val(data.amount);
    }
    })
    }
</script>
@endsection
