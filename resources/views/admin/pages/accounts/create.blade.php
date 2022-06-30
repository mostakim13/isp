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
                                <label for=""> Account Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" name="account_name"
                                    placeholder="Account Name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for=""> Head code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" name="head_code"
                                    placeholder="Head code">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Account Details</label>
                                <input type="text" class="form-control input-rounded" name="account_details"
                                    placeholder="Account Details">
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
