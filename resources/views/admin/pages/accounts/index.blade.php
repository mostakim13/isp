{{-- @dd($columns) --}}
@extends('admin.master')

@section('content')

<section id="ajax-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="pt-2 pr-2 pl-2 pt-1">
                    <h4 class="card-title">{{$page_heading ?? 'List'}}</h4>
                    <a href="{{ $view_url ?? '#' }}" target="_blank" class="btn btn-rounded btn-primary btn-sm ">
                        <span class="btn-icon-start text-white">
                            <i class="fa fa-eye"></i>
                        </span>
                        View
                    </a>
                    @if (isset($create_url) && $create_url)
                    <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-info btn-sm float-right">
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
