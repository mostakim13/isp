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
                                <label for="">Select Upazila <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="single-select" name="upazila_id">
                                    <option disabled selected>Select Upazila</option>
                                    @foreach($upozillas as $key=>$value)
                                    <option {{$editinfo->upozilla_id==$value->id ? "selected" : ''}}
                                        value="{{$value->id}}" >{{$value->upozilla_name}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label> Zone Name <span class="text-danger">*</span></label>
                                <select name="zone_id" class="form-control">
                                    <option value="" selected disabled>Select Zone</option>
                                    {{-- @foreach ($zones as $zone)
                                    <option value="{{$zone->id}}" {{ $editinfo->zone_id == $zone->id ? 'selected' : '' }}>{{$zone->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">SubZone Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" name="name" value="{{ old('name') ?? ($editinfo->name ?? '')}}"
                                    placeholder="Name">
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
@push('scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="district_id"]').on('change', function(){
            var district_id = $(this).val();
            if(district_id) {
                $.ajax({
                    url: "{{ route('zones.getUpozilla') }}",
                    type:"GET",
                    dataType:"json",
                    data:{
                       district_id:district_id
                    },
                    success:function(data) {
                       var d =$('select[name="upazila_id"]').empty();
                       let upazila = $('select[name="upazila_id"]');
                    upazila.append('<option disabled selected>Select Option</option>');
                          $.each(data, function(key, value){
                              $('select[name="upazila_id"]').append('<option value="'+ value.id +'">' + value.upozilla_name + '</option>');
                          });
                    },
                });
            } else {
                alert('danger');
            }
        });

    $('select[name="upazila_id"]').on('change', function() {
    var upozilla_id = $(this).val();
    if (upozilla_id) {
    $.ajax({
    url: "{{ route('subzones.getZone') }}",
    type: "GET",
    dataType: "json",
    data:{
    upozilla_id:upozilla_id
    },
    success: function(data) {
    var d = $('select[name="zone_id"]').empty();
    $.each(data, function(key, value) {
    $('select[name="zone_id"]').append(
    '<option value="' + value.id + '">' + value
        .name + '</option>');
    });
    },
    });
    } else {
    alert('danger');
    }
    });
    });
</script>

@endpush
