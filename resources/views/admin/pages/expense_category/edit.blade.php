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
                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text" class="form-control input-rounded" name="name" value="{{old('name') ? old('name') : ($editinfo->name ?? '')}}" placeholder="Name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Description</label>
                                <textarea type="text" class="form-control " name="description"  placeholder="Description">{{old('description') ? old('description') : ($editinfo->description ?? '')}}</textarea>
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
