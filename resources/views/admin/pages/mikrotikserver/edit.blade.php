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
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-1">
                                <label for="">Server IP</label>
                                <input type="text" class="form-control" value="{{ $editinfo->server_ip }}" name="server_ip"
                                    placeholder="server ip">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">User Name</label>
                                <input type="text" class="form-control" value="{{ $editinfo->user_name }}" name="user_name"
                                    placeholder="Username">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Password</label>
                                <input type="text" class="form-control" value="{{ $editinfo->password }}" name="password"
                                    placeholder="password">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">API Port</label>
                                <input type="text" class="form-control" value="{{ $editinfo->api_port }}" name="api_port"
                                    placeholder="api port">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">version</label>
                                <input type="text" class="form-control" value="{{ $editinfo->version }}" name="version"
                                    placeholder="version">
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
