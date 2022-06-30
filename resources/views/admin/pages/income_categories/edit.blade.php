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
                            <div class="col-md-6 col-6 mb-1">
                                <label for="">Service Category Type</label>
                                <input type="text" class="form-control input-rounded" name="service_category_type"
                                    value="{{ old('name') ?? ($editinfo->service_category_type ?? '')}}" placeholder="Service category type">
                            </div>

                            <div class="col-md-6 col-6 mb-1">
                                <label for="">Details(Optional)</label>
                                <input type="text" class="form-control input-rounded" name="details"
                                    value="{{ old('name') ?? ($editinfo->details ?? '')}}" placeholder="details">
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
