{{-- @dd($columns) --}}
@extends('admin.master')

@section('content')

<section id="ajax-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                        <tbody>
                            <tr>
                                <td>{{$installationFee->id}}</td>
                                <td>{{$installationFee->customer->created_on}}</td>
                                <td>{{$installationFee->id}}</td>
                                <td>{{$installationFee->id}}</td>
                                <td>{{$installationFee->id}}</td>
                                <td>{{$installationFee->id}}</td>
                                <td>{{$installationFee->id}}</td>
                                <td>{{$installationFee->id}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

{{-- @section('datatablescripts')
<!-- Datatable -->
<script type="text/javascript">
    let table = $('#server_side_lode').dataTable({
        dom:
            '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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
@endsection --}}
