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
                                <label for="">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="address">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Network <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="network">
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Interface</label>
                                <select name="interface" class="select2 form-control">
                                    <option disabled selected>Select Interface</option>
                                    @foreach($interfaces as $value)
                                    <option value="{{$value->name}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Mikrotik Servers</label>
                                <select name="server_id" class="select2 form-control">
                                    <option disabled selected>Select Server</option>
                                    @foreach($servers as $value)
                                    <option value="{{$value->id}}">{{$value->user_name}}({{$value->server_ip}})</option>
                                    @endforeach
                                </select>
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

@push('scripts')
<script>
    function availableBalance() {
        let balance = $('.payMeth option:selected').attr('available');
        $('.balance-message').text('Available balance is ' + balance);
    }
</script>
@endpush
