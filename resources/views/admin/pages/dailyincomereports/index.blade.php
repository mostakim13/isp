{{-- @dd($columns) --}}
@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h4 class="card-title">{{$page_heading ?? 'List'}}</h4>
                @if (isset($create_url) && $create_url)
                <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-info text-right">
                    <span class="btn-icon-start text-info">
                        <i class="fa fa-plus color-info"></i>
                    </span>
                    Add
                </a>
                @endif
            </div>
            <div class="card-body">
                <x-alert></x-alert>
                <div class="row">
                    <div class="col">
                        <select class="select2 selectwithsearch form-control select2-lg mb-3"
                            aria-label=".select2-lg example">
                            <option selected disabled>Select Income Category</option>
                            @foreach ($incomecategories as $incomecategory)
                            <option value="{{$incomecategory->id}}">{{$incomecategory->service_category_type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="start_date" placeholder="Start date">
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" placeholder="End date" name="end_date">
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="general_data_tables" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                @if (isset($is_show_checkbox) && $is_show_checkbox)
                                <th>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" id="checkAll" required="">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th>
                                @endif

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

        <div class="modal fade showing_page_modal_area" id="data_modal" tabindex="-1" role="dialog" aria-hidden="true">
        </div>
    </div>
</div>

@if(isset($model))
@include($model)
@endif
@endsection

@section('datatablescripts')
<!-- Datatable -->
<script src="{{asset('admin_assets/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin_assets/js/plugins-init/datatables.init.js')}}"></script>
<script type="text/javascript">
    let table = $('#general_data_tables').DataTable({
        language: {
            'paginate': {
                'previous': '<i class="fa fa-chevron-left"></i>',
                'next': '<i class="fa fa-chevron-right"></i>'
            }
        },
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ $ajax_url ?? '' }}",
            "dataType": "json",
            "type": "GET",
            "data": {
                "_token": "<?= csrf_token() ?>"
            }
        },

        pageLength: 100,
        aLengthMenu: [
            [10, 25, 50, 100, 200, 100000],
            [10, 25, 50, 100, 200, "All"]
        ],
        "columns": {{ Illuminate\Support\Js:: from($columns) }}
    });

    $(document).on('click', '.showdetails', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'html',
            success: function (data) {
                $('.modal').modal('show');
                $('#data_modal').html(data);
            }
        })
    })
</script>
@endsection
