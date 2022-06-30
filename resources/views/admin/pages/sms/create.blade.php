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
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <label for="">Header Title</label>
                                <input type="text" class="form-control input-rounded" value="{{old('header_text')}}"
                                    name="header_text" placeholder="Header Title">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <label for="">Body Message</label>
                                <textarea class="form-control" rows="30" name="body_text"
                                    placeholder="Body Message ....."></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <label for="">Message Type</label>
                                <select class="form-control" name="type">
                                    <option selected disabled>Select Option</option>
                                    @foreach(config('smstype') as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
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
