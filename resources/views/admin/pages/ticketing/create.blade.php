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
                                <label for="">Complain Number</label>
                                <input type="text" class="form-control input-rounded" name="complain_number"
                                    value="TN-{{random_int(10, 9999999999)}}" placeholder="Complain Number" readonly>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Problem Category</label>
                                <select class="form-control select2" id="problem_category" name="problem_category">
                                    <option disabled selected>Select category</option>
                                    @foreach($supportcategories as $key=>$value)
                                    <option {{old('problem_category')==$value->id ? "selected" : ''}}
                                        value="{{$value->id}}" >{{$value->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Attachments</label>
                                <input type="file" class="form-control input-rounded" name="attachment"
                                    value="{{ old('name') ?? ''}}" placeholder="attachment">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Note</label></br>
                               <textarea name="note" id="" cols="73" rows="8"></textarea>
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
