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
                            <div class="col-md-4 mb-1">
                                <label for=""> Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{$editinfo->company_name}}" name="company_name">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Contact Person <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{$editinfo->contact_person}}" name="contact_person">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control input-rounded" value="{{$editinfo->email}}"
                                    name="email">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Phone Number</label>
                                <input type="text" class="form-control input-rounded" value="{{$editinfo->phone}}"
                                    name="phone">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Mobile Number</label>
                                <input type="text" class="form-control input-rounded" value="{{$editinfo->mobile}}"
                                    name="mobile">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Facebook Url</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{$editinfo->facebook_url}}" name="facebook_url">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Skype Id</label>
                                <input type="text" class="form-control input-rounded" value="{{$editinfo->skype_id}}"
                                    name="skype_id">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Website Url</label>
                                <input type="text" class="form-control input-rounded" value="{{$editinfo->website_url}}"
                                    name="website_url">
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Address</label>
                                <input type="text" class="form-control input-rounded" value="{{$editinfo->address}}"
                                    name="address">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Image</label>
                                <input type="file" class="form-control mb-1 input-rounded" name="image">
                                <img src="{{asset($editinfo->image)}}" width="30%" alt="">
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
