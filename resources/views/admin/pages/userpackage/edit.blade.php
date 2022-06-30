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
                                <label for=""> Package *</label>
                                <input type="text" readonly class="form-control" value="{{ $editinfo->name }}"
                                    placeholder="Package">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for=""> Buy Price *</label>
                                <input type="text" readonly class="form-control" value="{{ $editinfo->rate }}"
                                    placeholder="Package">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for=""> Selling Price *</label>
                                <input type="number" class="form-control" name="price"
                                    value="{{ old('price') ?? ($editinfo->price ?? '')}}" placeholder="Selling price">
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
