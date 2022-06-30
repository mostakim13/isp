{{-- @dd($columns) --}}
@extends('admin.master')

@section('content')

<section id="ajax-datatable">
    <style>
        .card_style{
            height: 130px;
            color:white;
        }
        .fa-clipboard-check{
            font-size: 60px;
        }
        .fa-spin{
            font-size: 60px;
        }
        .fa-spinner{
            font-size: 60px;
        }
        .fa-thumbs-up{
            font-size: 60px;
        }
        .card-text{
            color: #fff;
        }
    </style>
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
                        Create Complain
                    </a>
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card bg-info card_style">
                            <div class="card-body row">
                                <div class="col-3 mb-2">

                                   <i class="fas fa-spinner fa-spin"></i>
                                </div>
                                <div class="col-9">
                                    <h5 class="card-title text-white">Total Tickets</h5>
                                    <h1 class="card-text">{{$total_ticket}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card bg-danger card_style">
                            <div class="card-body row">
                                <div class="col-3 mb-2">
                                    <i class="fa fa-cog fa-spin"></i>
                                </div>
                                <div class="col-9">
                                    <h5 class="card-title text-white">Pending Tickets</h5>
                                    <h1 class="card-text">{{$pending_ticket}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card bg-primary card_style">
                            <div class="card-body row">
                                <div class="col-3 mb-2">

                                    <i class="fa fa-sync fa-spin"></i>
                                </div>
                                <div class="col-9">
                                    <h5 class="card-title text-white">Processing Tickets</h5>
                                    <h1 class="card-text">{{$processing_ticket}}</h1>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card bg-success card_style">
                            <div class="card-body row">
                                <div class="col-3 mb-2">
                                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                </div>
                                <div class="col-9">
                                    <h5 class="card-title text-white">Solved Tickets</h5>
                                    <h1 class="card-text">{{$solved_ticket}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
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
