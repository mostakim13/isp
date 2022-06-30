@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-alert></x-alert>
            <div class="card">
                <div class="card-header">
                    <h4>Personal Information</h4>
                    <p>Fill Up All Required(<span class="text-red fw-bold fs-4">*</span>) Field Data</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label for="">Full Name</label>
                            <input type="text" class="form-control input-rounded" name="name"
                                value="{{ old('name') ?? $editinfo->name }}" placeholder="Your full name">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Father Name</label>
                            <input type="text" class="form-control input-rounded" name="father_name"
                                value="{{ old('father_name') ?? $editinfo->father_name  }}" placeholder="Father Name">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Mother Name</label>
                            <input type="text" class="form-control input-rounded" name="mother_name"
                                value="{{ old('mother_name') ?? $editinfo->mother_name }}" placeholder="Mother Name">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Spouse Name</label>
                            <input type="text" class="form-control input-rounded" name="spouse_name"
                                value="{{ old('spouse_name') ?? $editinfo->spouse_name }}" placeholder="Spouse Name">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Nid</label>
                            <input type="text" class="form-control input-rounded" name="nid"
                                value="{{ old('nid') ?? $editinfo->nid }}" placeholder="Nid">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Doc Image</label>
                            <input type="file" name="doc_image" value="{{ old('doc_image') }}"
                                class="form-file-input form-control ">

                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Date Of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob') ?? $editinfo->dob }}"
                                class="form-file-input form-control ">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Contact Information</h4>
                    <p>Fill Up All Required(<span class="text-red fw-bold fs-4">*</span>) Field Data</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label for="">Email</label>
                            <input type="email" class="form-control input-rounded" name="email"
                                value="{{ old('email') ?? $editinfo->email }}" placeholder="Email">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Phone</label>
                            <input type="text" class="form-control input-rounded" name="phone"
                                value="{{ old('phone') ?? $editinfo->phone }}" placeholder="Phone">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Address</label>
                            <input type="text" class="form-control input-rounded" name="address"
                                value="{{ old('address') ?? $editinfo->address }}" placeholder="Address">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Reference</label>
                            <input type="text" class="form-control input-rounded" name="reference"
                                value="{{ old('reference') ?? $editinfo->reference }}" placeholder="Reference">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Network & Product Information</h4>
                    <p>Fill Up All Required(<span class="text-red fw-bold fs-4">*</span>) Field Data</p>
                    {{-- <h4 class="card-title">{{$page_heading ?? 'Create'}}</h4> --}}
                    {{-- <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a> --}}
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label for="">Zone</label>
                            <div class="input-group mb-1">
                                <select name="zone_id" id="zone_id" class="form-control input-rounded">
                                    <option selected="" disabled>-- Select Zone --</option>
                                    @foreach ($zones as $item)
                                    <option value="{{$item->id}}" {{$editinfo->zone_id == $item->id ? 'selected' : ''
                                        }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Subzone</label>
                            <div class="input-group mb-1">
                                <select name="subzone_id" id="subzone_id" class="form-control input-rounded">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">TJ</label>
                            <div class="input-group mb-1">
                                <select name="tj_id" id="tj_id" class="form-control input-rounded">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">TJ Core</label>
                            <div class="input-group mb-1">
                                <select name="tj_core_id" id="tj_core_id" class="form-control input-rounded">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Splitter</label>
                            <div class="input-group mb-1">
                                <select name="splitter_id" id="splitter_id" class="form-control input-rounded">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Splitter Core</label>
                            <div class="input-group mb-1">
                                <select name="splitter_core_id" id="splitter_core_id"
                                    class="form-control input-rounded">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label for="">Mac Address</label>
                            <input type="text" class="form-control input-rounded" name="mac_address"
                                value="{{ old('mac_address') ?? $editinfo->mac_address }}" placeholder="Mac Address">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">IP Address</label>
                            <input type="text" class="form-control input-rounded" name="ip_address"
                                value="{{ old('ip_address') ?? $editinfo->ip_address }}" placeholder="Ip Address">
                        </div>

                        <div class="col-md-6 mb-1">
                            <label for="device_id">Device <samp class="text-denger">✱</samp></label>
                            <div class="input-group mb-1">
                                <select name="device_id" id="device_id" class="form-control input-rounded">
                                    <option selected="" disabled>-- Select Device --</option>
                                    @foreach ($devices as $item)
                                    <option value="{{$item->id}}" {{$editinfo->device_id == $item->id ?
                                        'selected' : ''
                                        }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="connection_type_id">Connection Type <samp class="text-denger">✱</samp></label>
                            <div class="input-group mb-1">
                                <select name="connection_type_id" id="connection_type_id"
                                    class="form-control input-rounded">
                                    <option selected="" disabled>-- Select Connection --</option>
                                    @foreach ($connectionType as $item)
                                    <option value="{{$item->id}}" {{$editinfo->connection_type_id == $item->id ?
                                        'selected' : ''
                                        }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="protocol_type_id">Protocol Type <samp class="text-denger">✱</samp></label>
                            <div class="input-group mb-1">
                                <select name="protocol_type_id" disabled onchange="protocoltype()" id="protocol_type_id"
                                    class="form-control input-rounded">
                                    <option selected disabled>-- Select Protocol --</option>
                                    @foreach ($protocolTypes as $item)
                                    <option value="{{$item->id}}" {{$editinfo->protocol_type_id == $item->id ?
                                        'selected' : ''
                                        }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Server Name</label>
                            <select name="server_id" class="form-control">
                                <option selected disabled>Select Option</option>
                                @foreach($servers as $server);
                                <option {{$editinfo->server_id == $server->id ? "selected":"" }}
                                    value="{{$server->id}}">{{$server->user_name}} ({{$server->server_ip}})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card staticIpDiv">
                <div class="card-header">
                    <h2>Static Ip</h2>
                    <p>Fill Up All Required(<span class="text-danger fw-bold fs-4">*</span>) Field Data</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <label for="">Name <span class="text-danger">★</span></label>
                            <input type="text" class="form-control queueName" name="queue_name"
                                value="{{ old('queue_name') ?? $editinfo->queue_name }}">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Target <span class="text-danger">★</span></label>
                            <input type="text" class="form-control queueTarget" name="queue_target"
                                value="{{ old('queue_target') ?? $editinfo->queue_target }}">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Dst</label>
                            <input type="text" class="form-control queueDst" name="queue_dst"
                                value="{{ old('queue_dst') ?? $editinfo->queue_dst }}">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Max Upload</label>
                            <input type="text" class="form-control queueMaxUpload" name="queue_max_upload"
                                value="{{ old('queue_max_upload') ?? $editinfo->queue_max_upload }}">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Max Download</label>
                            <input type="text" class="form-control queueMaxDownload" name="queue_max_download"
                                value="{{ old('queue_max_download') ?? $editinfo->queue_max_download }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Service Information</h4>
                    <p>Fill Up All Required(<span class="text-red fw-bold fs-4">*</span>) Field Data</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <div class="form-group mb-1">
                                <label for="">Username</label>
                                <input type="text" class="form-control input-rounded" name="username"
                                    value="{{ old('username') ?? $editinfo->username}}">
                            </div>

                            <div class="form-group mb-1">
                                <label for="">P P P Profile</label>
                                <select name="m_p_p_p_profile" class="form-control input-rounded">
                                    <option selected disabled>Select Package</option>
                                    @foreach($profiles as $value)
                                    <option {{$editinfo->m_p_p_p_profile == $value->id ? "selected":"" }}
                                        value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-1">
                                <label for="">Billing Status</label>
                                <select name="billing_status_id" class="form-control input-rounded">
                                    <option selected disabled>Select Billing Status</option>
                                    @foreach($billingStatus as $value)
                                    <option {{$editinfo->billing_status_id == $value->id ? "selected":"" }}
                                        value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-1">
                                <label for="">Connection Date</label>
                                <input type="date" class="form-control input-rounded" name="connection_date"
                                    value="{{ old('connection_date') ?? $editinfo->connection_date }}">
                            </div>

                            <div class="form-group mb-1">
                                <label for="">Password</label>
                                <input type="password" class="form-control input-rounded" name="password"
                                    value="{{ old('password')  }}">
                            </div>
                            <div class="form-group mb-1">
                                <label for="">Confirm Password</label>
                                <input type="password" class="form-control input-rounded" name="password_confirmation"
                                    value="{{ old('new-password')  }}">
                            </div>
                            <div class="form-group mb-1">
                                <label for="">Skip Month</label>
                                <input type="number" min="1" class="form-control input-rounded" name="duration"
                                    value="{{ old('duration') ?? $editinfo->duration }}" placeholder="Skip Month">
                            </div>

                            <div class="form-group mb-1">
                                <label for="">Disabled</label>
                                <select name="disabled" class="form-control input-rounded">
                                    <option {{$editinfo->disabled == 'true' ? "selected":""}} value="true">True
                                    </option>
                                    <option {{$editinfo->disabled == 'false' ? "selected":""}} value="false">False
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-6 mb-1">

                            <div class="form-group mb-1">
                                <label for="">Package</label>
                                <select name="package_id" class="form-control input-rounded"
                                    onchange="profileId(this.value)">
                                    <option selected disabled>Select Package</option>
                                    @foreach($packages as $value)
                                    <option {{$editinfo->package_id == $value->id ? "selected":"" }}
                                        value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-1">
                                <label for="">Client Type</label>
                                <select name="client_type_id" class="form-control input-rounded">
                                    <option selected disabled>Select Client</option>
                                    @foreach($clientType as $value)
                                    <option {{$editinfo->client_type_id == $value->id ? "selected":"" }}
                                        value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-1">
                                <label for="">Started date</label>
                                <input type="date" class="form-control input-rounded speedcls" name="start_date"
                                    value="{{ old('start_date') ?? $editinfo->start_date }}" placeholder="Speed">
                            </div>
                            <div class="form-group mb-1">
                                <label for="">Billing By</label>
                                <select name="billing_type" class="form-control input-rounded">
                                    <option {{$editinfo->billing_type == "month_to_month" ? "selected":""}} selected
                                        value="month_to_month">Month To Month
                                    </option>
                                    <option {{$editinfo->billing_type == "day_to_day" ? "selected":""}}
                                        value="day_to_day">Day To Day</option>
                                </select>
                            </div>
                            <div class="form-group mb-1">
                                <label for="">Speed</label>
                                <input type="text" class="form-control input-rounded speedcls" name="speed"
                                    value="{{ old('speed') ?? $editinfo->speed}}" placeholder="Speed">
                            </div>

                            <div class="form-group mb-1">
                                <label for="">Bill Amount</label>
                                <input type="text" class="form-control input-rounded billAmount" name="bill_amount"
                                    value="{{ old('bill_amount') ?? $editinfo->bill_amount}}" placeholder="Bill Amount">
                            </div>

                            <div class="form-group mb-1">
                                <label for="">Bill Collection Date</label>
                                <input type="number" min="0" max="31" class="form-control input-rounded"
                                    name="bill_collection_date"
                                    value="{{ old('bill_collection_date') ?? $editinfo->bill_collection_date}}"
                                    placeholder="Bill Collection Date">
                            </div>

                            <div class="form-group mb-1">
                                <label for="">Billing Person</label>
                                <select name="billing_person" id="billing_person" class="form-control input-rounded">
                                    <option value="">Select Billing Person</option>
                                    @foreach($users as $user)
                                    <option {{$editinfo->billing_person == $user->id ? "selected":"" }}
                                        value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-1">
                                <label for="">Comment</label>
                                <input type="text" class="form-control input-rounded" name="comment"
                                    value="{{ old('comment') ?? $editinfo->comment}}">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"> Save</button>
            </div>

        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>


    function protocoltype() {
        let protoclVal = $('#protocol_type_id option:selected').val();
        if (protoclVal == 1) {
            $('.staticIpDiv').show();
            $('.pppprofile').hide();

        } else {
            $('.staticIpDiv').hide();
            $('.pppprofile').show();

            $('.queueName').val('');
            $('.queueTarget').val('');
            $('.queueDst').val('');
            $('.queueMaxUpload').val('');
            $('.queueMaxDownload').val('');
        }
    }
    protocoltype();

    function profileId(e) {
        $.ajax({
            url: "{{route('customers.get_profile')}}",
            method: "GET",
            data: {
                id: e
            },
            success: function (data) {
                $('.speedcls').val(data.speed);
                $('.billAmount').val(data.amount);
            }
        })
    }

    $(document).on('change', '#zone_id', function () {
        $.ajax({
            url: "{{route('api.subzones')}}",
            method: "get",
            data: {
                zone_id: $(this).val()
            },
            success: function (data) {
                $('#subzone_id').empty();
                $('#subzone_id').html(data);
            }
        });
    });

    $(document).on('change', '#subzone_id', function () {
        $.ajax({
            url: "{{route('api.new_tj')}}",
            method: "POST",
            data: {
                subzone_id: $(this).val()
            },
            success: function (data) {
                $('#tj_id').empty();
                $('#tj_id').html(data);
            }
        });
    });
    $(document).on('change', '#tj_id', function () {
        $.ajax({
            url: "{{route('api.new_cores')}}",
            method: "POST",
            data: {
                model_name: "App\\Models\\Tj",
                model_id: $(this).val()
            },
            success: function (data) {
                $('#tj_core_id').empty();
                $('#tj_core_id').html(data);
            }
        });
    });
    $(document).on('change', '#tj_core_id', function () {
        $.ajax({
            url: "{{route('api.new_splitters')}}",
            method: "POST",
            data: {
                column_name: "tj_core_id",
                id: $(this).val()
            },
            success: function (data) {
                $('#splitter_id').empty();
                $('#splitter_id').html(data);
            }
        });
    });
    $(document).on('change', '#splitter_id', function () {
        $.ajax({
            url: "{{route('api.new_cores')}}",
            method: "POST",
            data: {
                model_name: "App\\Models\\Splitter",
                model_id: $(this).val()
            },
            success: function (data) {
                $('#splitter_core_id').empty();
                $('#splitter_core_id').html(data);
            }
        });
    });
</script>
@endsection
