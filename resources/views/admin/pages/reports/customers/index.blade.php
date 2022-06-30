@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h4 class="card-title">{{$page_heading ?? 'Bill Receive History'}}</h4>
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
                                <th>Code</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Package</th>
                                <th>Service</th>
                                <th>Bill Amount</th>
                                <th>Profile</th>
                                <th>Status</th>
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
                "label": "Code",
                "data": "code",
            },
            {
                "label": "Username",
                "data": "username",
            },
            {
                "label": "Secreat",
                "data": "secreat",
            },
            {
                "label": "Name",
                "data": "name",
            },
            {
                "label": "Phone",
                "data": "phone",
            },
            {
                "label": "Package",
                "data": "package",
            },
            {
                "label": "Service",
                "data": "service",
            },
            {
                "label": "Bill Amount",
                "data": "bill_amount",
            },
            {
                "label": "Profile",
                "data": "profile",
            },
            {
                "label": "Status",
                "data": "status",
            },
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
