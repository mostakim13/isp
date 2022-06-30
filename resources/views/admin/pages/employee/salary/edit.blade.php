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
                                <label for=""> Select Month <span class="text-danger">*</span></label>
                                <?php
                                $months = App\Models\Salary::where("status","due")->get();
                                ?>
                                {{-- <input type="text" class="form-control input-rounded" name="account_name"
                                    placeholder="Account Name"> --}}
                                <select class="select2 select2-lg mb-1" onchange="productView(this.value)"
                                    aria-label=".select2-lg example" name="month">
                                    <option selected disabled>Select Month</option>
                                    @foreach ($months as $month)
                                    <option value="{{$month->id}}">{{$month->month}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Due</label>
                                <input type="text" class="form-control input-rounded" name="due" id="due" readonly>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Paid</label>
                                <input type="number" class="form-control input-rounded" name="paid_salary" id="paid"
                                    placeholder="Paid Salary">
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
@section('scripts')
<script type="text/javascript">
    //start product view with modal
    function productView(id) {
        $.ajax({
            url: "{{route('salarys.ajax')}}",
            method: 'GET',
            dataType: 'json',
            data: {
                id: id
            },
            success: function (data) {
                $('#due').val(data.due);
            }
        })
    }

    $('#paid').on('input', function () {
        let _dueVal = $('#due').val();
        let _paidval = $(this).val();
        if (Number(_dueVal) < Number(_paidval)) {
            let _paidval = $(this).val(_dueVal);
            return alert("You can't");
        }
    });
</script>
@endsection
