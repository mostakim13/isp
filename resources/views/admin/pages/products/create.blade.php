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
                                <label for="">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ old('name')}}" name="name"
                                    placeholder="Category Name">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Select Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="single-select" name="product_category_id">
                                    <option disabled selected>Select Category</option>
                                    @foreach($ProductCategory as $key=>$value)
                                    <option {{old('product_category_id')==$value->id ? "selected" : ''}}
                                        value="{{$value->id}}" >{{$value->name}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Select Unit <span class="text-danger">*</span></label>
                                <select class="form-control js-example-disabled" name="unit_id">
                                    <option disabled selected>Select Unit</option>
                                    @foreach($units as $key=>$value)
                                    <option {{old('unit_id')==$value->id ? "selected" : ''}}
                                        value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Select Brand <span class="text-danger">*</span></label>
                                <select class="form-control js-example-disabled" name="brand_id">
                                    <option disabled selected>Select Unit</option>
                                    @foreach($brands as $key=>$value)
                                    <option {{old('brand_id')==$value->id ? "selected" : ''}}
                                        value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Purchases Price <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ old('purchases_price')}}"
                                    name="purchases_price" placeholder="Purchases Price">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Sale Price <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ old('sale_price')}}" name="sale_price"
                                    placeholder="Sale Price">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Low Stock</label>
                                <input type="text" class="form-control" value="{{ old('low_stock')}}" name="low_stock"
                                    placeholder="Low Stock">
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
