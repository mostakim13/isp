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
                <div class="table-responsive">
                    <table id="general_data_tables" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>R.Date</th>
                                <th>C.Code</th>
                                <th>ID/IP</th>
                                <th>Name</th>
                                <th>Zone</th>
                                <th>Package</th>
                                <th>B.Status</th>
                                <th>MonthlyBill</th>
                                <th>Received</th>
                                <th>Money Receipt No</th>
                                <th>CreatedBy</th>
                                <th>ReceivedBy</th>
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
        "columns": [
            {
                "label": "R.Date",
                "data": "r_date",
            },
            {
                "label": "C.Code",
                "data": "code",
            },
            {
                "label": "ID/IP",
                "data": "username",
            },
            {
                "label": "Name",
                "data": "name",
            },
            {
                "label": "Zone",
                "data": "zone",
            },
            {
                "label": "Package",
                "data": "package",
            },
            {
                "label": "B.Status",
                "data": "status",
            },
            {
                "label": "MonthlyBill",
                "data": "customer_billing_amount",
            },
            {
                "label": "Received",
                "data": "pay_amount",
            },
            {
                "label": "Money Receipt No",
                "data": "money_receipt",
            },
            {
                "label": "CreatedBy",
                "data": "created_by",
            },
            {
                "label": "ReceivedBy",
                "data": "received_by",
            }
        ]
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
                $('#view_details').html(data);
            }
        })
    })
</script>
@endsection
