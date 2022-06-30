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
                        <h4>Main</h4>

                        <div class="mb-1">
                            <input type="text" class="form-control input-rounded" name="name" placeholder="Name">
                        </div>
                        <h4>Limits</h4>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_download"
                                    placeholder="Download">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_upload"
                                    placeholder="Upload">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_transfer"
                                    placeholder="Transfer">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_uptime"
                                    placeholder="Uptime">
                            </div>
                        </div>
                        <h4>Rate Limits</h4>
                        <div class="row">
                            <label for="">Rate Limite</label>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_rate_limite_rx"
                                    placeholder="RX">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_rate_limite_tx"
                                    placeholder="TX">
                            </div>
                        </div>
                        <div class="row">
                            <label for="">Burst rate</label>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_burst_rate_rx"
                                    placeholder="RX">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_burst_rate_tx"
                                    placeholder="TX">
                            </div>
                        </div>
                        <div class="row">
                            <label for="">Burst threshold</label>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_burst_threshold_rx"
                                    placeholder="RX">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_burst_threshold_tx"
                                    placeholder="TX">
                            </div>
                        </div>
                        <div class="row">
                            <label for="">Burst time</label>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_burst_time_rx"
                                    placeholder="RX">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_burst_time_tx"
                                    placeholder="TX">
                            </div>
                        </div>
                        <div class="row">
                            <label for="">Min Rate</label>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_min_rate_rx"
                                    placeholder="RX">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_min_rate_tx"
                                    placeholder="TX">
                            </div>
                        </div>
                        <div class="row">
                            <label for="">Priority</label>
                            <div class="col-md-6 mb-1">
                                <select name="m_priority" class="default-select form-control wide mb-1">
                                    <option selected="selected">Not specified</option>
                                    <option>1 - Highest</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>8 - Lowest</option>
                                </select>
                            </div>
                        </div>
                        <h4>Constraints</h4>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_group_name"
                                    placeholder="Group Name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_ip_pool"
                                    placeholder="IP Pool">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_ipv6_pool"
                                    placeholder="IPV6 Pool">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control input-rounded" name="m_address_list"
                                    placeholder="Address list">
                            </div>
                        </div>
                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
