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
                                <label for="">Select District <span class="text-danger">*</span></label>
                                <select class="form-control " id="district_id" name="district_id">
                                    <option disabled selected>Select District</option>
                                    @foreach($districts as $key=>$value)
                                    <option {{old('district_id')==$value->id ? "selected" : ''}}
                                        value="{{$value->id}}" >{{$value->district_name}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Select Upazila <span class="text-danger">*</span></label>
                                <select id="sub-category" class="form-control select2" id="upozilla_id" name="upazila_id">
                                    <option disabled selected>Select Upazila</option>
                                    {{-- @foreach($upozillas as $key=>$value)
                                    <option districts={{$value->district_id}} {{old('upozilla_id')==$value->id ? "selected" : ''}}
                                        value="{{$value->id}}" >{{$value->upozilla_name}} </option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for=""> Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" name="name" value="{{ old('name') ?? ''}}"
                                    placeholder="Name">
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

@push('scripts')
<script>
    // $(document).ready(function() {
        $(document).on('change','#district_id' ,function(){
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
                          $.each(data, function(key, value){
                              $('select[name="upazila_id"]').append('<option value="'+ value.id +'">' + value.upozilla_name + '</option>');
                          });
                    },
                });
            } else {
                alert('danger');
            }
        });
    // });
</script>
@endpush
