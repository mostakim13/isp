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
                                <label for="">TARIFF NAME</label>
                                <input type="text" class="form-control" id="tariff_name" value="{{ old('tariff_name')}}"
                                    name="tariff_name">
                                <span class="tariff_name_error text-danger d-none">Please provide a Tariff Name
                                </span>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">PACKAGE NAME</label>
                                <select id="package_id" class="form-control">
                                    <option>Select Option</option>
                                    @foreach($macpackages as $macpackage)
                                    <option value="{{$macpackage->id}}">{{$macpackage->name}}</option>
                                    @endforeach
                                </select>
                                <span class="package_error text-danger d-none">Please select a Package Name
                                </span>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">PACKAGE RATE</label>
                                <input type="number" class="form-control" id="package_rate"
                                    value="{{ old('package_rate')}}">
                                <span class="package_rate_error text-danger d-none">Please provide a Package Rate</span>
                            </div>
                            <!-- <div class="col-md-6 mb-1">
                                <label for="">PACKAGE VALIDITY DAYS</label>
                                <input type="text" class="form-control" value="30" id="validation_day">
                                <span class="validation_day_error text-danger d-none">Please provide a Validation
                                    Day</span>
                            </div> -->
                            <!-- <div class="col-md-6 mb-1">
                                <label for="">PACKAGE MINIMUM ACTIVATION DAYS</label>
                                <input type="text" class="form-control" value="1" id="minimum_activation_day">
                                <span class="activation_day_error text-danger d-none">Please provide a
                                    Minimum activation day</span>
                            </div> -->
                            <div class="col-md-6 mb-1">
                                <label for="">SERVER NAME</label>
                                <select id="server_id" onchange="getProfile(this.value)" class="form-control">
                                    <option>Select Option</option>
                                    @foreach($servers as $server)
                                    <option value="{{$server->id}}">{{$server->user_name}} ({{$server->server_ip}})
                                    </option>
                                    @endforeach
                                </select>
                                <span class="server_error text-danger d-none">Please select a server</span>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">PROTOCOL TYPE</label>
                                <select id="protocole_type" class="form-control">
                                    <option>Select Option</option>
                                    @foreach($protocols as $protocol)
                                    <option value="{{$protocol->id}}">{{$protocol->name}}</option>
                                    @endforeach
                                </select>
                                <span class="protocole_type_error text-danger d-none">Please select a server</span>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">PROFILE (SPEED)</label>
                                <select id="m_profile_id" class="form-control">
                                    <option>Select Option</option>
                                </select>
                                <span class="m_profile_error text-danger d-none">Please select a Profile</span>
                            </div>
                            <div class="col-md-12 mb-1" style="text-align:right">
                                <button type="button" onclick="tableadd()" class="btn btn-success">Add
                                    Package</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-center">
                            <div class="cal-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive text-center">
                                        <thead class="thead-success">
                                            <tr role="row">
                                                <th>Sr. No.</th>
                                                <th>Package</th>
                                                <th>Server</th>
                                                <th>Protocol</th>
                                                <th>Profile</th>
                                                <th>Rate</th>
                                                <!-- <th>Validity Days</th> -->
                                                <!-- <th>Minimum Activation Days</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-1">
                                <button type="reset" class="btn btn-danger">Clear</button>
                                <button type="submit" class="btn btn-info">Save</button>
                            </div>
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
    var count = 0;
    function tableadd() {
        let tariff_name = $("#tariff_name");
        if (!tariff_name.val()) {
            $('.tariff_name_error').removeClass('d-none');
            return;
        } else {
            $('.tariff_name_error').addClass('d-none');
        }

        let package = $("#package_id option:selected");
        if (!($('#package_id').val())) {
            $('.package_error').removeClass('d-none');
            return;
        } else {
            $('.package_error').addClass('d-none');
        }

        let rate = $("#package_rate");
        if (!(rate.val())) {
            $('.package_rate_error').removeClass('d-none');
            return;
        } else {
            $('.package_rate_error').addClass('d-none');
        }

        // let validation_day = $("#validation_day");
        // if (!(validation_day.val())) {
        //     $('.validation_day_error').removeClass('d-none');
        //     return;
        // } else {
        //     $('.validation_day_error').addClass('d-none');
        // }

        // let minimum_activation_day = $("#minimum_activation_day");
        // if (!(minimum_activation_day.val())) {
        //     $('.activation_day_error').removeClass('d-none');
        //     return;
        // } else {
        //     $('.activation_day_error').addClass('d-none');
        // }

        let server = $("#server_id option:selected");
        if (!($('#server_id').val())) {
            $('.server_error').removeClass('d-none');
            return;
        } else {
            $('.server_error').addClass('d-none');
        }

        let protocole_type = $("#protocole_type option:selected");
        if (!($('#protocole_type').val())) {
            $('.protocole_type_error').removeClass('d-none');
            return;
        } else {
            $('.protocole_type_error').addClass('d-none');
        }

        let m_profile = $("#m_profile_id option:selected");
        if (!($('#m_profile_id').val())) {
            $('.m_profile_error').removeClass('d-none');
            return;
        } else {
            $('.m_profile_error').addClass('d-none');
        }

        count += 1;
        let table = `<tr>`;
        table += `<td>`;
        table += count;
        table += `</td>`;
        table += `<td>`;
        table += `${package.text()} <input name="package_id[]" type="hidden" value="${package.val()}" /> <input name="package_name[]" type="hidden" value="${package.text()}" />`;
        table += `</td>`;
        table += `<td>`;
        table += `${server.text()} <input name="server_id[]" type="hidden" value="${server.val()}" />`;
        table += `</td>`;
        table += `<td>`;
        table += `${protocole_type.text()} <input name="protocole_type[]" type="hidden" value="${protocole_type.val()}" />`;
        table += `</td>`;
        table += `<td>`;
        table += `${m_profile.text()} <input name="m_profile_id[]" type="hidden" value="${m_profile.val()}" /><input name="m_profile_name[]" type="hidden" value="${m_profile.text()}" />`;
        table += `</td>`;
        table += `<td>`;
        table += `${rate.val()} <input name="rate[]" type="hidden" value="${rate.val()}" />`;
        table += `</td>`;
        // table += `<td>`;
        // table += `${validation_day.val()} <input name="validation_day[]" type="hidden" value="${validation_day.val()}" />`;
        // table += `</td>`;
        // table += `<td>`;
        // table += `${minimum_activation_day.val()} <input name="minimum_activation_day[]" type="hidden" value="${minimum_activation_day.val()}" />`;
        // table += `</td>`;
        table += `<td>`;
        table += `<button type="button" class="btn btn-danger btn-sm row_remove"><i class="fa fa-trash"></i></button>`;
        table += `</td>`;
        table += `</tr>`;
        $('tbody').append(table);

        $("select option").prop("selected", false);
        rate.val('');
        validation_day.val(30);
        minimum_activation_day.val(1);
    }

    $(document).on('click', '.row_remove', function () {
        if (confirm('Are You sure')) {
            $(this).closest('tr').remove();
        }
    })

    function getProfile(serverId) {
        let url = "{{route('mactariffconfig.getprofile')}}";
        let column = "server_id";
        $.ajax({
            url: url,
            method: "GET",
            dataType: "html",
            data: {
                id: serverId,
                column: column,
                modelname: "App\\Models\\MPPPProfile"
            },
            success: function (data) {
                $('#m_profile_id').html(data);
            }
        })
    }

</script>
@endpush
