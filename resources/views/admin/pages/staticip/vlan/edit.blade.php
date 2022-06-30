@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Edit'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="">Name <span class="text-danger">*</span></label>
                                <input type="text" value="{{$editinfo->name}}" class="form-control" name="name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Mtu <span class="text-danger">*</span></label>
                                <input type="text" value="{{$editinfo->mtu}}" class="form-control" name="mtu">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Arp <span class="text-danger">*</span></label>
                                <select name="arp" class="select2 form-control">
                                    <option {{$editinfo->arp == 'disabled' ? "selected":""}} value="disabled">disabled
                                    </option>
                                    <option {{$editinfo->arp == 'enabled' ? "selected":""}} value="enabled">enabled
                                    </option>
                                    <option {{$editinfo->arp == 'local-proxy-arp' ? "selected":""}}
                                        value="local-proxy-arp">local
                                        proxy arp</option>
                                    <option {{$editinfo->arp == 'proxy-arp' ? "selected":""}} value="proxy-arp">proxy
                                        arp</option>

                                    <option {{$editinfo->arp == 'reply-only' ? "selected":""}}
                                        value="reply-only">reply only</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Vlan Id <span class="text-danger">*</span></label>
                                <input type="text" value="{{$editinfo->vlan_id}}" class="form-control" name="vlan_id">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Interface</label>
                                <select name="interface" class="select2 form-control">
                                    <option disabled selected>Select Interface</option>
                                    @foreach($interfaces as $value)
                                    <option {{$editinfo->interface == $value->name ? "selected":""}}
                                        value="{{$value->name}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Mikrotik Servers</label>
                                <select name="server_id" class="select2 form-control">
                                    <option disabled selected>Select Server</option>
                                    @foreach($servers as $value)
                                    <option {{$editinfo->server_id == $value->id ? "selected":""}}
                                        value="{{$value->id}}">{{$value->user_name}}({{$value->server_ip}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Use Service tag</label>
                                <select name="use_service_tag" class="select2 form-control">
                                    <option disabled selected>Select Interface</option>
                                    <option {{$editinfo->use_service_tag == 'true' ? "selected":""}} value="true">Yes
                                    </option>
                                    <option {{$editinfo->use_service_tag == 'false' ? "selected":""}} value="false">No
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-1 form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function availableBalance() {
        let balance = $('.payMeth option:selected').attr('available');
        $('.balance-message').text('Available balance is ' + balance);
    }
    availableBalance();
</script>
@endpush
