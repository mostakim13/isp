@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">


            <div class="card">
<div class="card-header">
    <h4 class="card-title">{{$page_heading}}</h4>
    <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
</div>
                <div class="card-body">
                    <x-alert></x-alert>
                    <div class="basic-form">
                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="row">

                        <div class="col-md-6  mb-1">
                            <label for="">Received Amount</label>
                            <input type="number" class="form-control" name="received_amount" max="{{$installationFee->installation_fee - $installationFee->received_amount}}"
                                placeholder="0">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="payment_method">Payment Method<samp class="text-denger">✱</samp></label>
                            <select name="payment_by" id="protocol_type_id" class="form-control select2">
                                <option selected="" disabled>Select method</option>
                                @foreach ($accounts as $item)
                                <option value="{{$item->id}}">{{$item->account_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Received By</label>
                            <select name="received_by" id="protocol_type_id" class="form-control select2">
                                <option selected="" disabled>Select employees</option>
                                @foreach ($employees as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="">Received On</label>
                            <input type="date" class="form-control" name="received_on">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary"> Save</button>
                        </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>



    </div>
</div>
@endsection
{{-- @section('scripts')
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
@endsection --}}
