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
                            <div class="col-md-6 mb-3">
                                <select name="employee_id" class="default-select form-control wide mb-3">
                                    <option selected="selected">Select Employe</option>
                                    @foreach ($employees as $key => $value)
                                    <option value="{{ $value->user_id }}">
                                        {{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="account_id" class="default-select form-control wide mb-3">
                                    <option selected="selected">Select Account</option>
                                    @foreach ($account as $key => $value)
                                    <option value="{{ $value->id }}">
                                        {{ $value->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">

                                <div class="input-group mb-3">
                                    <button class="btn btn-primary btn-sm" type="button">Date</button>
                                    <div class="form-file">
                                        <input type="date" name="date" value="{{ old('date') }}"
                                            class="form-file-input form-control ">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">

                                <input type="text" class="form-control input-rounded" name="amount"
                                    placeholder="Amount">
                            </div>
                            <div class="col-md-6 mb-3">

                                <textarea type="text" class="form-control input-rounded" name="note"
                                    placeholder="Note here"></textarea>
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
