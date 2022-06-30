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
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Client Type</label>
                                <select name="client_type_id"
                                    class="input-rounded default-select form-control wide mb-1">
                                    <option selected="selected">Not specified</option>
                                    @foreach ($client_types as $client)
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Package Name (<span class="text-danger">*</span>)</label>
                                <input type="text" class="form-control input-rounded" name="name" placeholder="Name"
                                    required>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Price (<span class="text-danger">*</span>)</label>
                                <input type="number" class="form-control input-rounded" name="price" placeholder="Price"
                                    required>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Bandwidth Allocation (MB)</label>
                                <input type="text" class="form-control input-rounded" name="bandwidth_allocation"
                                    placeholder="Bandwidth Allocation">
                            </div>
                            <div class="col-md-12 mb-1">
                                <label for="text-capitalize">Mik.PPP Profile</label>
                                <select name="m_profile_id" class="select2 form-control">
                                    <option value="1">Select Option</option>
                                    @foreach($mprofiles as $mprofile)
                                    <option value="{{$mprofile->id}}">{{$mprofile->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-1">
                                <label for="text-capitalize">IS SHOW ON CLIENT PROFILE?</label>
                                <select name="is_show_in_client_profile"
                                    class="default-select input-rounded form-control wide mb-1">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-1">
                                <label for="text-capitalize"> Description</label>
                                <textarea class="form-control" name="description" rows="10"></textarea>
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
