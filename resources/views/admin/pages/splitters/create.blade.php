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
                        <div class="row ">
                            <div class="col-md-4 mb-1">
                                <label for="">Zone</label>
                                <select class="form-control" name="zone_id" id="zone_id">
                                    <option selected disabled>Select Option</option>
                                    @foreach($zones as $key=>$value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Subzone</label>
                                <select class="form-control" name="subzone_id" id="subzone_id">
                                    <option selected disabled>Select Option</option>

                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Tj</label>
                                <select class="form-control" name="tj_id" id="tj_id">
                                    <option selected disabled>Select Option</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Available Cores For Tj</label>
                                <select class="form-control" name="tj_core_id" id="tj_core_id">
                                    <option selected disabled>Select Option</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Splitter</label>
                                <select class="form-control" name="splitter_id" id="splitter_id">
                                    <option selected disabled>Select Option</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Available Cores for Splitter</label>
                                <select class="form-control" name="splitter_core_id" id="splitter_core_id">
                                    <option selected disabled>Select Option</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Splitter Name</label>
                                <input type="text" class="form-control input-rounded" value="{{old('name')}}"
                                    name="name" placeholder="Name">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Core</label>
                                <input type="text" class="form-control input-rounded core" value="{{old('core')}}"
                                    name="core" placeholder="Ex:16">
                            </div>

                            <div class="color_section row"></div>

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
        $(document).on('change', '#splitter_id', function () {
            let self = $(this);
            $.ajax({
                "url": "{{ route('api.cores') }}",
                "type": "GET",
                "data": {
                    model_name: "App\\Models\\Splitter",
                    model_id: self.val()
                },
                cache: false,
                success: function (data) {
                    $('#splitter_core_id').empty();
                    $('#splitter_core_id').html(data);
                }
            });
        });

        $(document).on('change', '#tj_id', function () {
            let self = $(this);
            $.ajax({
                "url": "{{ route('api.cores') }}",
                "type": "GET",
                "data": {
                    model_name: "App\\Models\\Tj",
                    model_id: self.val()
                },
                cache: false,
                success: function (data) {
                    $('#tj_core_id').empty();
                    $('#tj_core_id').html(data);
                }
            });
        });


        $(document).on('input keyup', '.core', function () {
            let val = $(this).val();
            let col = ``;


            for (let index = 0; index < val; index++) {
                // const element = array[index];
                col += `
                <div class="col-md-4 mb-1">
                    <label for="">Color Name</label>
                    <input type="text" class="form-control input-rounded" name="colors[]"
                        placeholder="Ex:red">
                </div>
                `;

            }

            $('.color_section').html(col);
        });
    });

</script>
@endsection
