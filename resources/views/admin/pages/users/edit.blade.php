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

                        <div class="mb-1">
                            <label>Name</label>
                            <input type="text" class="form-control input-rounded" name="name"
                                value="{{ old('name') ?? ($editinfo->name ?? '' )}}" placeholder="Name">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label>Username</label>
                                <input type="text" class="form-control input-rounded" name="username"
                                    value="{{ old('username') ?? ($editinfo->username ?? '' )}}" placeholder="Username">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Email</label>
                                <input type="email" class="form-control input-rounded" name="email"
                                    value="{{ old('email') ?? ($editinfo->email ?? '' )}}" placeholder="Email">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Phone</label>
                                <input type="text" class="form-control input-rounded" name="phone"
                                    value="{{ old('phone') ?? ($editinfo->phone ?? '' )}}" placeholder="Phone">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Password</label>
                                <input type="password" class="form-control input-rounded" name="password"
                                    placeholder="Password">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Confirmation Password</label>
                                <input type="password" class="form-control input-rounded" name="password_confirmation"
                                    placeholder="Password">
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
