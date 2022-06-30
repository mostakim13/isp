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
                                <label for="">Tj Box</label>
                                <select class="form-control" name="tj_id" id="tj_id">
                                    <option selected disabled>Select Option</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Available Cores</label>
                                <select class="form-control" name="core_id" id="core_id">
                                    <option selected disabled>Select Option</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Tj Name</label>
                                <input type="text" class="form-control input-rounded" value="{{old('name')}}"
                                    name="name" placeholder="Name">
                            </div>

                            <div class="col-md-4 mb-1">
                                <label >Core</label>
                                <input type="number" class="form-control input-rounded" id="core" value="{{old('core')}}" name="core" placeholder="Ex:16">
                            </div>

                            <div class="color_section row">

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
@section('scripts')
<script>
    $(document).ready(function () {
        $(document).on('change', '#zone_id', function(){
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

        $(document).on('change', '#subzone_id', function(){
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


        $(document).on('change', '#tj_id', function(){
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
                    $('#core_id').empty();
                    $('#core_id').html(data);
                }
            });
        });

        $(document).on('input keydown', '#core', function(e){

            let val = $(this).val();
            let col = ``;


            for (let index = 0; index < val; index++) {
                col  += `
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
