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
                            <div class="col-md-12 mb-1">
                                <label for="">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" name="name"
                                    value="{{ old('name') ?? ($editinfo->name ?? '')}}"
                                    placeholder="Name">
                            </div>

                            <div class="col-md-12 mb-1">
                                <label class="text-uppercase">Details(optional)</label>
                                <textarea class="form-control" name="details" rows="10">{{ old('details') ?? ($editinfo->details ?? '') }}</textarea>
                            </div>
                            <div class="col-md-12 mb-1">
                                <label for="text-capitalize"> Featured Image</label>
                                <input type="file" class="form-file-input form-control" name="image">

                                <div>
                                    {!! $editinfo->image !!}
                                </div>
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
