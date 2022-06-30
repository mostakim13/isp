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
                                <label for=""> Reason Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" name="reason_name"
                                    placeholder="Reason Name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for=""> Status</label>
                                <select class="select2 form-control" name="status">
                                    <option selected disabled>Select status</option>

                                    <option value="1">Yes</option>
                                    <option value="2">No</option>

                                </select>
                            </div>

                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
