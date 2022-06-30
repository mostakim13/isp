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
                            <div class="col-md-6 mb-1">
                                <label for="">Mik Server <span class="text-danger">*</span></label>
                                <select name="server_id" class="form-control select2" id="">
                                    <option selected disabled>Select Server</option>
                                    @foreach($servers as $server)
                                    <option {{$editinfo->server_id == $server->id ? "selected":""}}
                                        value="{{$server->id}}">{{$server->user_name}}({{$server->server_ip}})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for=""> Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{old('name') ?? ($editinfo->name ?? '') }}" name="name" placeholder="Name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Address</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{old('ranges') ?? ($editinfo->ranges ?? '')}}" name="ranges"
                                    placeholder="Address">
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
