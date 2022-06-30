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
                            <div class="col-md-4 mb-1">
                                <label for="">Category Name <span class="text-danger">*</span></label>
                                <input type="text" value="{{$editinfo->name}}" class="form-control input-rounded"
                                    name="name">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Sub-Category</label>
                                <select {{$subcategorys->isEmpty() ? "disabled":""}} name="parent" class="form-control"
                                    >
                                    <option disabled>Sub-Category</option>
                                    @foreach($subcategorys as $subcategory)
                                    <option {{$editinfo->parent == "0" ? "selected":""}} value="0">Root Category
                                    </option>
                                    <option {{$editinfo->parent == $subcategory->id ? "selected":""}}
                                        value="{{$subcategory->id}}">{{$subcategory->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-4 mb-1">
                                <label for="">Status</label>
                                <select name="status" class="form-control" id="">
                                    <option {{$editinfo->parent == "active" ? "selected":""}} value="active">Active
                                    </option>
                                    <option {{$editinfo->parent == "inactive" ? "selected":""}}
                                        value="inactive">InActive
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-1">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" id="" cols="30" rows="10">
                                    {{$editinfo->description}}
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
