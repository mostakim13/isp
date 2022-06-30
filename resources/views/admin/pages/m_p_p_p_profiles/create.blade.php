@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Create'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-6 mb-1">
                                <label for="">Name</label>
                                <input type="text" class="form-control input-rounded" name="name" placeholder="Name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Local Address</label>
                                <input type="text" name="local_address" class="form-control input-rounded">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Remote Address</label>
                                <select name="remote_address" class="form-control select2">
                                    <option selected option>Select Option</option>
                                    @foreach($mpools as $mpool)
                                    <option value="{{$mpool->id}}">{{$mpool->name}}</option>
                                    @endforeach
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Bridge learning</label>
                                <select name="bridge_learning" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Server Name</label>
                                <select name="server_id" class="form-control select2">
                                    <option value="" selected disabled>Select server name</option>
                                    @foreach ($mikrotik_servers as $mikrotik_server)
                                    <option value="{{$mikrotik_server->id}}">{{$mikrotik_server->user_name}}
                                        ({{$mikrotik_server->server_ip}})</option>
                                    @endforeach

                                </select>
                            </div>
                            <!-- <div class="col-md-6 mb-1">
                                <label for="">Use Mpls</label>
                                <input type="text" class="form-control input-rounded" name="use_mpls"
                                    placeholder="Use Mpls">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Use Compression</label>
                                <input type="text" class="form-control input-rounded" name="use_compression"
                                    placeholder="Use Compression">
                            </div>
                              <div class="col-md-6 mb-1">
                                <label for="">Use Encryption</label>
                                <input type="text" class="form-control input-rounded" name="use_encryption"
                                    placeholder="Use Encryption">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Only One</label>
                                <input type="text" class="form-control input-rounded" name="only_one"
                                    placeholder="Only One">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Address List</label>
                                <input type="text" class="form-control input-rounded" name="address_list"
                                    placeholder="Address List">
                            </div> -->
                            <div class="col-md-6 mb-1">
                                <label for="">Dns Server</label>
                                <input type="text" class="form-control input-rounded" name="dns_server"
                                    placeholder="Dns Server">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Amount</label>
                                <input type="text" class="form-control input-rounded" name="amount"
                                    placeholder="Amount">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Speed</label>
                                <input type="text" class="form-control input-rounded" name="speed" placeholder="Speed">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Change Tcp_mss</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="yes" name="change_tcp_mss"
                                        id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Yes
                                    </label>
                                </div>


                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="no" name="change_tcp_mss"
                                        id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        No
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="default" checked
                                        name="change_tcp_mss" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Default
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">

                                <label for="">Use Upnp</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="yes" name="use_upnp"
                                        id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="no" name="use_upnp"
                                        id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        No
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" checked value="default" name="use_upnp"
                                        id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Default
                                    </label>
                                </div>

                            </div>


                        </div>

                        <div class="mb-1 form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
