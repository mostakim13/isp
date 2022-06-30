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
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-1">
                                <label for="">Support Category</label>
                                <input type="text" class="form-control" value="{{ old('name') ?? $editinfo->name}}"
                                    name="name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Responsible Department</label>
                                <select name="department" class="form-control" id="">
                                    <option disabled selected>Select</option>
                                    @foreach(config('SupportDipertment') as $dipertment)
                                    <option {{ $editinfo->department == $dipertment ? "selected":""}}
                                        value="{{$dipertment}}">{{$dipertment}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-1">
                                <label for="">Is This Category As Public?</label>
                                <select name="type" class="form-control" id="">
                                    <option {{ $editinfo->type == "public" ? "selected":""}} value="public">Yes
                                    </option>
                                    <option {{ $editinfo->type == "unpublic" ? "selected":""}} value="unpublic">No
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-1">
                                <label for="">Support Category</label>
                                <textarea name="details" class="form-control" id="" cols="30" rows="10">
{{$editinfo->details}}
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
