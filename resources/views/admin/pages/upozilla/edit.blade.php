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
                                <label for="">Select District <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="single-select" name="district_id">
                                    <option disabled selected>Select District</option>
                                    @foreach($districts as $key=>$value)
                                    <option {{$editinfo->district_id==$value->id ? "selected" : ''}}
                                        value="{{$value->id}}" >{{$value->district_name}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label>Upazila Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" name="upozilla_name"
                                    placeholder="Upazila name" value="{{ old('upozilla_name') ?? ($editinfo->upozilla_name ?? '')}}">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label>Details</label>
                                <textarea type="text" class="form-control " name="details"
                                    placeholder="Details">{{$editinfo->details}}</textarea>
                            </div>
                        </div>

                        <div class=" form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    document.getElementById("date").value = date;
</script>
@endsection
