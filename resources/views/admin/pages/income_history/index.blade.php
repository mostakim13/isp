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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3 mb-1">
                                        <label for="">Category</label>
                                        <select class="select2 form-control mb-1" id="categorysearch">
                                            <option selected disabled>Select Category</option>
                                            @foreach($incomecategories as $incomecategorie)
                                            <option value="{{$incomecategorie->id}}">
                                                {{$incomecategorie->service_category_type}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-1">
                                        <label for="">Customer</label>
                                        <select class="select2 form-control mb-1" id="customersearch">
                                            <option selected disabled>Select Customer</option>
                                            @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">
                                                {{$customer->name}}({{$customer->username}})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-1">
                                        <label for="">Supplier </label>
                                        <select class="select2 form-control mb-1" id="suppliersearch">
                                            <option selected disabled>Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}">
                                                {{$supplier->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-1">
                                        <label for="">Account Head </label>
                                        <select class="select2 form-control mb-1" id="accountsearch">
                                            <option selected disabled>Select Supplier</option>
                                            @foreach($accounts as $value)
                                            <option value="{{$value->id}}">
                                                {{$value->account_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

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
    let table = $('#server_side_lode').DataTable({
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

    $('#categorysearch').change(function () {
        table.columns(2).search(this.value).draw();
    });
    $('#customersearch').change(function () {
        table.columns(3).search(this.value).draw();
    });
    $('#suppliersearch').change(function () {
        table.columns(5).search(this.value).draw();
    });
    $('#accountsearch').change(function () {
        table.columns(4).search(this.value).draw();
    });
</script>
@endsection
