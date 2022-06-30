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
                            <div class="col-md-4 mb-1">
                                <label for="">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" name="name">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Sub-Category</label>
                                <select {{$subcategorys->isEmpty() ? "disabled":""}} name="parent" class="form-control"
                                    >
                                    <option disabled selected>Sub-Category</option>
                                    @foreach($subcategorys as $subcategory)
                                    <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Status</label>
                                <select name="status" class="form-control" id="">
                                    <option value="active">Active</option>
                                    <option value="inactive">InActive</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-1">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
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
