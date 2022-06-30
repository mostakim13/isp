{{-- @dd($columns) --}}
@extends('admin.master')

@section('content')

<section id="ajax-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-alert></x-alert>
                <div class="row m-1">
                    <div class="col">
                        <label for=""><h5>From Date</h5></label>
                        <input type="date" class="form-control" name="" id="">
                    </div>
                    <div class="col">
                        <label for=""><h5>To Date</h5></label>
                        <input type="date" class="form-control" name="" id="">
                    </div>
                    <div class="col">
                        <label for=""><h5>Setup Status</h5></label>
                        <select class="form-control js-example-disabled" name="brand_id">
                            <option disabled selected>Select status</option>
                            @foreach($statuses as $key=>$value)
                            <option value="{{$value->id}}">{{$value->status}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for=""><h5>Setup By</h5></label>
                        <select class="form-control select2 js-example-disabled" name="brand_id">
                            <option disabled selected>Select employee</option>
                            @foreach($employees as $key=>$value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{$page_heading ?? 'List'}}</h4>
                    @if (isset($create_url) && $create_url)
                    <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-info text-right">
                        <span class="btn-icon-start text-white">
                            <i class="fa fa-plus"></i>
                        </span>
                        Add
                    </a>
                    @endif
                </div>
                <div class="card-datatable table-responsive">
                    <table id="server_side_lode" class="table">
                        <thead>
                            <tr>
                                @if (isset($columns) && $columns)
                                @foreach ($columns as $column)
                                <th>{{$column['label']}}</th>
                                @endforeach
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('datatablescripts')
<!-- Datatable -->
<script type="text/javascript">
    let table = $('#server_side_lode').dataTable({
        dom:
            '<"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        "processing": true,
        "serverSide": true,
        retrieve: true,
        "ajax": {
            "url": "{{ $ajax_url ?? '' }}",
            "dataType": "json",
            "type": "GET",
        },
        pageLength: 100,
        aLengthMenu: [
            [10, 25, 50, 100, 200, 100000],
            [10, 25, 50, 100, 200, "All"]
        ],
        "columns": {{ \Illuminate\Support\Js:: from($columns) }}
    })

</script>
@endsection
