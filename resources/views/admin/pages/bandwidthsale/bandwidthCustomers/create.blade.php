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
                            <div class="card-header">
                                <h2>Customer Information</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="name" value="{{ old('name') ?? ''}}" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Code</label>
                                            <input type="text" class="form-control input-rounded" name="code" value="{{ old('code') ?? ''}}" placeholder="Code">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Contact Person <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="contact_person" value="{{ old('contact_person') ?? ''}}" placeholder="Contact Person">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Email</label>
                                            <input type="text" class="form-control input-rounded" name="email" value="{{ old('email') ?? ''}}" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Mobile <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="mobile" value="{{ old('mobile') ?? ''}}" placeholder="Mobile">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Phone</label>
                                            <input type="text" class="form-control input-rounded" name="phone" value="{{ old('phone') ?? ''}}" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control input-rounded">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Reference By</label>
                                            <input type="text" class="form-control input-rounded" name="reference_by" value="{{ old('reference_by') ?? ''}}" placeholder="reference_by">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase"> Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="address" value="{{ old('address') ?? ''}}" placeholder="address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Remarks</label>
                                            <input type="text" class="form-control input-rounded" name="remarks" value="{{ old('remarks') ?? ''}}" placeholder="remarks">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Facebook <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="facebook" value="{{ old('facebook') ?? ''}}" placeholder="facebook">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Skype ID</label>
                                            <input type="text" class="form-control input-rounded" name="skypeid" value="{{ old('skypeid') ?? ''}}" placeholder="skypeid">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Website</label>
                                            <input type="text" class="form-control input-rounded" name="website" value="{{ old('website') ?? ''}}" placeholder="website">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Image <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control input-rounded" name="image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h2>Transmission Information</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">nttn info</label>
                                            <input type="text" class="form-control input-rounded" name="nttn_info" value="{{ old('nttn_info') ?? ''}}" placeholder="nttn_info">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">vlan info</label>
                                            <input type="text" class="form-control input-rounded" name="vlan_info" value="{{ old('vlan_info') ?? ''}}" placeholder="vlan_info">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">vlan id</label>
                                            <input type="text" class="form-control input-rounded" name="vlan_id" value="{{ old('vlan_id') ?? ''}}" placeholder="vlan_id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">SCR OR LINK ID</label>
                                            <input type="text" class="form-control input-rounded" name="scr_or_link_id" value="{{ old('scr_or_link_id') ?? ''}}" placeholder="scr_or_link_id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">activation date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="activition_date" value="{{ old('activition_date') ?? ''}}" placeholder="activition_date">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">ip address</label>
                                            <input type="text" class="form-control input-rounded" name="ipaddress" value="{{ old('ipaddress') ?? ''}}" placeholder="ip address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">pop name</label>
                                            <input type="text" class="form-control input-rounded" name="pop_name" value="{{ old('pop_name') ?? ''}}" placeholder="pop_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                        </div>

                        {{-- <div class="card">
                            <div class="card-header">
                                <h2>Login Information</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">UserName</label>
                                            <input type="text" class="form-control input-rounded" name="username" value="{{ old('username') ?? ''}}"
                                                placeholder="username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Password *</label>
                                            <input type="password" class="form-control input-rounded" name="password"
                                                placeholder="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Confirm Password *</label>
                                            <input type="password" class="form-control input-rounded" name="password_confirmation"
                                                placeholder="Re-enter your password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
