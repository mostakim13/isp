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
                        <div class="row ">
                            <div class="col-md-4 mb-1">
                                <label for="">Zone</label>
                                <select class="form-control" name="zone_id" id="zone_id">
                                    <option selected disabled>Select Option</option>
                                    @foreach($zones as $value)
                                    <option value="{{$value->id}}" {{$value->id == $editinfo->zone_id ? 'selected' :
                                        ''}}>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Subzone</label>
                                <select class="form-control" name="subzone_id" id="subzone_id">
                                    <option selected disabled>Select Option</option>
                                    @foreach($subzones as $value)
                                    <option value="{{$value->id}}" {{$value->id == $editinfo->subzone_id ? 'selected' :
                                        ''}}>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Tj Box</label>
                                <select class="form-control" name="tj_id" id="tj_id">
                                    <option selected disabled>Select Option</option>
                                    @foreach($tjs as $value)
                                    <option value="{{$value->id}}" {{$value->id == $editinfo->tj_id ? 'selected' :
                                        ''}}>{{$value->name}} ({{$value->remain}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Splitter</label>
                                <select class="form-control" name="splitter_id" id="splitter_id">
                                    <option selected disabled>Select Option</option>
                                    @foreach($boxes as $value)
                                    <option value="{{$value->id}}" {{$value->id == $editinfo->splitter_id ? 'selected' :
                                        ''}}>{{$value->name}} ({{$value->remain}})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Splitter Name</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('name') ?? ($editinfo->name ?? '')}}" name="name" placeholder="Name">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">core</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('core') ?? ($editinfo->core ?? '')}}" name="core" placeholder="Ex:16">
                            </div>

                            {{-- <div class="col-md-6 mb-1">
                                <label for="">Connected</label>
                                <input type="text" class="form-control input-rounded" readonly>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Remain</label>
                                <input type="text" class="form-control input-rounded" readonly>
                            </div> --}}

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
@section('scripts')
<script>
    $(document).ready(function () {
        $(document).on('change', '#zone_id', function () {
            let self = $(this);
            $.ajax({
                "url": "{{ route('api.subzones') }}",
                "type": "GET",
                "data": {
                    zone_id: self.val()
                },
                cache: false,
                success: function (data) {
                    $('#subzone_id').empty();
                    $('#subzone_id').html(data);
                }
            });
        });

        $(document).on('change', '#subzone_id', function () {
            let self = $(this);
            $.ajax({
                "url": "{{ route('api.tjs') }}",
                "type": "GET",
                "data": {
                    subzone_id: self.val()
                },
                cache: false,
                success: function (data) {
                    $('#tj_id').empty();
                    $('#tj_id').html(data);
                }
            });
        });

        $(document).on('change', '#tj_id', function () {
            let self = $(this);
            $.ajax({
                "url": "{{ route('api.splitters') }}",
                "type": "GET",
                "data": {
                    tj_id: self.val()
                },
                cache: false,
                success: function (data) {
                    $('#splitter_id').empty();
                    $('#splitter_id').html(data);
                }
            });
        });
    });

</script>
@endsection
