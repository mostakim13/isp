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
                                <label for=""> EMPLOYEE NAME <span class="text-danger">*</span></label>
                                {{-- <input type="text" class="form-control input-rounded" name="account_name"
                                    placeholder="Account Name"> --}}
                                <select class="select2 form-control select2-lg" aria-label=".select2-lg example"
                                    name="employee_id">
                                    <option selected disabled>Select employee</option>
                                    @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">MONTH</label>
                                <input type="month" class="form-control input-rounded" name="month"
                                    placeholder="Account Details">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">PAID SALARY</label>
                                <input type="number" class="form-control input-rounded" name="paid_salary"
                                    placeholder="Ex:2000" min="0">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">OVERTIME</label>
                                <input type="number" class="form-control input-rounded" name="overtime"
                                    placeholder="Ex:2000" min="0">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">INCENTIVE</label>
                                <input type="number" class="form-control input-rounded" name="incentive"
                                    placeholder="Ex:2000" min="0">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">BONUS</label>
                                <input type="number" class="form-control input-rounded" name="bonus"
                                    placeholder="Ex:2000" min="0">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">PAID DATE</label>
                                <input type="date" class="form-control input-rounded" name="paid_date"
                                    placeholder="Ex:2000" min="">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">REMARKS/NOTE</label>
                                <input type="text" class="form-control input-rounded" name="remarks"
                                    placeholder="Remarks">
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
