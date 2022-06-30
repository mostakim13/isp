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
                                <label for="">Sub Category</label>
                                <select class="form-control select2" id="single-select" name="category_id">
                                    <option {{ $editinfo->category_id == "0" ? "selected":""}} value="0" selected>Root
                                        Category</option>
                                    @foreach($productCats as $key=>$value)
                                    <option {{ $editinfo->category_id == $value->id ? "selected":""}}
                                        value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
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
