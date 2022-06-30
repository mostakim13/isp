@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="{{back() ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">
                <x-alert></x-alert>
                <div class="basic-form">
                    <form id="searchsalary">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <h3 for="">Search Month</h3>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="month" class="form-control input-rounded" name="date">
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                        <input type="number" class="form-control input-rounded d-none" value="{{$employee->user_id}}"
                            name="uid">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header justify-content-center">
                <h4 class="card-title text-center">{{$employee->name}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Reason</th>
                                <th>Create By</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center">Search By Month</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#searchsalary').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                "url": "{{route('employees.salary.history.search')}}",
                "method": "POST",
                "dataType": "html",
                processData: false,
                contentType: false,
                "data": new FormData(this),
                success: function (data) {
                    $('tbody').html(data);
                }
            })
        })
    })
</script>
@endsection
