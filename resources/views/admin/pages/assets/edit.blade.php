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
                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Category Name</label>
                                <input type="text" class="form-control input-rounded" name="category_name"
                                    value="{{$editinfo->category_name}}" placeholder="Category name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Status</label>
                                {{-- <input type="text" class="form-control input-rounded" name="reason_name"
                                    placeholder="Reason Name"> --}}
                                <select class="select2 select2-lg mb-1" name="status" aria-label=".select2-lg example">
                                    <option selected disabled>Select Status</option>

                                    <option value="1" {{ $editinfo->status == 1 ? 'selected':'' }}>Yes</option>
                                    <option value="2" {{ $editinfo->status == 2 ? 'selected':'' }}>No</option>

                                </select>
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
