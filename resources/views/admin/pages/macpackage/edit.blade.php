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
                                <label for="">Name</label>
                                <input type="text" class="form-control" value="{{ $editinfo->name }}" name="name"
                                    placeholder="Category Name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">BANDWITH ALLOCATION MB (ONLY FOR BTRC REPORT)</label>
                                <input type="number" class="form-control"
                                    value="{{ old('bandwidth_md') ?? $editinfo->bandwidth_md}}" name="bandwidth_md"
                                    placeholder="Bandwidth Name">
                            </div>

                            <div class="col-md-12 mb-1">
                                <label for="">DETAILS(OPTIONAL)</label>
                                <textarea name="details" class="form-control" id="" cols="30" rows="10">
                                    {{ $editinfo->details }}
                                </textarea>
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
