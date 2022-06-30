@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h4 class="card-title">{{$page_heading ?? 'List'}}</h4>
                @if (isset($create_url) && $create_url)
                <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-info text-right">
                    <span class="btn-icon-start">
                        <i class="fa fa-plus color-info"></i>
                    </span>
                    Add
                </a>
                @endif
            </div>
            <div class="card-body">
                <x-alert></x-alert>
                <div class="table-responsive">
                    <table id="example" class="display dataTable" style="min-width: 845px">
                        <thead>
                            <tr>
                                <td>SL</td>
                                <td>Server IP</td>
                                <td>User Name</td>
                                <td>Password</td>
                                <td>API Port</td>
                                <td>Version</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataList as $value)
                            <tr>
                                <td>{{$value->iteration}}</td>
                                <td>{{$value->server_ip}}</td>
                                <td>{{$value->user_name}}</td>
                                <td>{{$value->password}}</td>
                                <td>{{$value->api_port}}</td>
                                <td>{{$value->version}}</td>
                                <td>
                                    <a class="btn shadow btn-sm sharp me-2" data-toggle="modal"
                                        data-target="#data_modal" data-id="{{$value->id}}">
                                        <i data-feather='refresh-ccw'></i>
                                    </a>
                                    <a href="{{route('mikrotikserver.edit',$value->id)}}"
                                        class="btn shadow btn-sm sharp me-2">
                                        <i data-feather="edit"></i>
                                    </a>
                                    <a href="{{route('mikrotikserver.destroy',$value->id)}}"
                                        class="btn shadow btn-sm sharp me-2">
                                        <i data-feather="trash"></i>

                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="data_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sync Server</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="syncsubmit" method="post">
                        <div class="modal-body">
                            <div class="serverid">
                                <input type="hidden" name="mik_id" class="mik_id">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Get User By name</label>
                                    <input type="text" id="syncVal" class="form-control" name="name">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer submitbtn">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sync"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
    $(document).on('click', '.showdetails', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let id = $(this).data('id');
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'html',
            success: function (data) {
                $('.modal').modal('show');
                $('.mik_id').val(id);
            }
        })
    })

    $(document).on('submit', '.syncsubmit', function (e) {
        e.preventDefault();
        let button = `<button type="submit" class="btn btn-primary"><i class="fas fa-sync"></i></button>`;
        let gif = `<img src="{{asset('sync.gif')}}" style="width: 10%;" alt="">`;
        $('.submitbtn').html(gif);
        let name = $("#syncVal").val();
        let mikId = $(".mik_id").val();
        $.ajax({
            url: "{{route('mikrotikserver.sync')}}",
            method: 'POST',
            data: {
                "_token": "{{csrf_token()}}",
                name: name,
                mikid: mikId
            },
            success: function (data) {

                $('.submitbtn').html(button);
            }
        })
    })
</script>
@endsection
