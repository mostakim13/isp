@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title ">{{$page_heading ?? 'Create'}}
                </h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ route('supportticket.statusupdate',$statusupdate->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="form-group mb-1 col-md-3 col-sm-4 col-xs-12">
                                <label>Connection Status</label><br>
                                <input id="clSupportUptime" class="form-control form-padding bg-gray" readonly="">
                            </div>
                            <div class="form-group mb-1 col-md-3 col-sm-4 col-xs-12">
                                <label>Status</label><br>
                                <input type="text" style="background: red;color: white;" class="form-control"
                                    value="Offline">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="form-group mb-1 col-md-3 col-sm-4 col-xs-12">
                                <label>Mac Address/Caller Id</label><br>
                                <input id="clSupportMac" value="{{$statusupdate->mac_address}}"
                                    class="form-control form-padding bg-gray" readonly="">
                            </div>
                            <div class="form-group mb-1 col-md-3 col-sm-4 col-xs-12">
                                <label>IP Address</label><br>
                                <input id="clSupportIp" value="{{$statusupdate->ip_address}}"
                                    class="form-control form-padding bg-gray" readonly="">
                            </div>
                        </div>
                        <div class="mb-1 form-group" style="text-align:right">
                            <button type="submit" class="btn btn-success">Solved</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
