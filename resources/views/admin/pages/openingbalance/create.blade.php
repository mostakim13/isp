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

                        <div class="form-row">
                            <div class="col-md-4 mb-1">
                                <label>Date:</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="date" name="_date" data-toggle="datetimepicker"
                                        value="{{ date('Y-m-d') }}" class="form-control datetimepicker-input"
                                        data-target="#reservationdate" />
                                </div>
                                @error('date')
                                <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="validationCustom01">Account Name <span class="text-danger">*</span> :</label>
                                <select class="form-control select2" name="account_id">
                                    <option selected disabled value="">--Select--</option>
                                    @foreach ($accounts as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->account_name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="validationCustom01">Amount <span class="text-danger">*</span> :</label>
                                <input type="text" name="amount" class="form-control" id="validationCustom01"
                                    placeholder="Amount" value="{{ old('amount') }}" required>
                                @error('amount')
                                <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="validationCustom02">Note <span class="text-danger">*</span> :</label>
                                <textarea name="note" rows="1" class="form-control" id="validationCustom02"
                                    placeholder="Note" value="{{ old('note') }}" required></textarea>
                                @error('note')
                                <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
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
