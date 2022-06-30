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
                            <div class="card-header">
                                <h2>Customer Information</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="name" value="{{ old('name') ?? ($editinfo->name ?? '')}}"
                                                placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Code</label>
                                            <input type="text" class="form-control input-rounded" name="code" value="{{ old('code') ?? ($editinfo->code ?? '')}}"
                                                placeholder="Code">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Contact Person <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="contact_person"
                                                value="{{ old('contact_person') ?? ($editinfo->contact_person ?? '')}}" placeholder="Contact Person">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Email</label>
                                            <input type="text" class="form-control input-rounded" name="email" value="{{ old('email') ?? ($editinfo->email ?? '')}}"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Mobile <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="mobile" value="{{ old('mobile') ?? ($editinfo->mobile ?? '')}}"
                                                placeholder="Mobile">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Phone</label>
                                            <input type="text" class="form-control input-rounded" name="phone" value="{{ old('phone') ?? ($editinfo->phone ?? '')}}"
                                                placeholder="Phone">
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
                                            <input type="text" class="form-control input-rounded" name="reference_by"
                                                value="{{ old('reference_by') ?? ($editinfo->reference_by ?? '')}}" placeholder="reference_by">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="address"
                                                value="{{ old('address') ?? ($editinfo->address ?? '')}}" placeholder="address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Remarks</label>
                                            <input type="text" class="form-control input-rounded" name="remarks"
                                                value="{{ old('remarks') ?? ($editinfo->remarks ?? '')}}" placeholder="remarks">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Facebook <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="facebook"
                                                value="{{ old('facebook') ?? ($editinfo->facebook ?? '')}}" placeholder="facebook">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Skype ID</label>
                                            <input type="text" class="form-control input-rounded" name="skypeid"
                                                value="{{ old('skypeid') ?? ($editinfo->skypeid ?? '')}}" placeholder="skypeid">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Website</label>
                                            <input type="text" class="form-control input-rounded" name="website"
                                                value="{{ old('website') ?? ($editinfo->website ?? '')}}" placeholder="website">
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
                                            <label class="text-uppercase">NTTN Info</label>
                                            <input type="text" class="form-control input-rounded" name="nttn_info"
                                                value="{{ old('nttn_info') ?? ($editinfo->nttn_info ?? '')}}" placeholder="nttn_info">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">VLAN Info</label>
                                            <input type="text" class="form-control input-rounded" name="vlan_info"
                                                value="{{ old('vlan_info') ?? ($editinfo->vlan_info ?? '')}}" placeholder="vlan_info">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">VLAN ID</label>
                                            <input type="text" class="form-control input-rounded" name="vlan_id"
                                                value="{{ old('vlan_id') ?? ($editinfo->vlan_id ?? '')}}" placeholder="vlan_id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">SCR OR LINK ID</label>
                                            <input type="text" class="form-control input-rounded" name="scr_or_link_id"
                                                value="{{ old('scr_or_link_id') ?? ($editinfo->scr_or_link_id ?? '')}}" placeholder="scr_or_link_id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Activition date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control input-rounded" name="activition_date"
                                                value="{{ old('activition_date') ?? ($editinfo->activition_date ?? '')}}" placeholder="activition_date">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">IP address</label>
                                            <input type="text" class="form-control input-rounded" name="ipaddress"
                                                value="{{ old('ipaddress') ?? ($editinfo->ipaddress ?? '')}}" placeholder="ipaddress">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Pop Name</label>
                                            <input type="text" class="form-control input-rounded" name="pop_name"
                                                value="{{ old('pop_name') ?? ($editinfo->pop_name ?? '')}}" placeholder="pop_name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h2>Login Information</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">UserName</label>
                                            <input type="text" class="form-control input-rounded" name="username"
                                                value="{{ old('username') ?? ($editinfo->username ?? '')}}" placeholder="username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control input-rounded" name="password" placeholder="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control input-rounded" name="password_confirmation"
                                                placeholder="Re-enter your password">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 form-group">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
