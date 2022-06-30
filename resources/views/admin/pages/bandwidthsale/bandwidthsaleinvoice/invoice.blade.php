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
                    <div class="row">
                        <div class="col-md-6">
                            {!! $company->logo !!}
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                            <h3>INVOICE</h3>
                            <p>{{$editinfo->customer->name}}</p>
                        </div>
                        <div class="col-md-3  mb-3">
                            <table class="table">
                                <thead style="background-color: darkblue;color: beige;">
                                    <tr>
                                        <th scope="col" width="10%"> Item</th>
                                        <th scope="col"> Description</th>
                                        <th scope="col"> Unit</th>
                                        <th scope="col"> Quantity</th>
                                        <th scope="col"> Rate</th>
                                        <th scope="col"> VAT(%)</th>
                                        <th scope="col"> From Date</th>
                                        <th scope="col"> To Date</th>
                                        <th scope="col"> Total</th>
                                        <th scope="col"> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($editinfo->detaile as $details)
                                    <tr>
                                        <th scope="row">
                                            <select name="item_id[]" class="form-control item_id">
                                                <option value="">Select</option>
                                                @foreach($items as $item)
                                                <option {{$details->item_id == $item->id ? "selected":""}}
                                                    value="{{$item->id}}">{{$item->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </th>
                                        <th scope="row">
                                            <textarea name="description[]" class="form-control" cols="10" rows="10">
                                                {{$details->description}}
                                                </textarea>
                                        </th>
                                        <th scope="row">
                                            <input type="text" value="{{$details->unit}}" name="unit[]"
                                                class="form-control unit" readonly>
                                        </th>
                                        <th scope="row">
                                            <input type="text" value="{{$details->qty}}" name="qty[]"
                                                class="form-control qty calculation">
                                        </th>
                                        <th scope="row">
                                            <input type="text" value="{{$details->rate}}" name="rate[]"
                                                class="form-control rate calculation">
                                        </th>
                                        <th scope="row">
                                            <input type="text" name="vat[]" value="{{$details->vat}}"
                                                class="form-control vat calculation">
                                        </th>
                                        <th scope="row">
                                            <input type="date" name="from_date[]" value="{{$details->from_date}}"
                                                class="form-control ">
                                        </th>
                                        <th scope="row">
                                            <input type="date" name="to_date[]" value="{{$details->to_date}}"
                                                class="form-control">
                                        </th>
                                        <th scope="row">
                                            <input type="text" name="total[]" value="{{$details->total}}"
                                                class="form-control total">
                                        </th>
                                        <th scope="row">
                                            <button class="btn btn-danger remove">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </th>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10" style="text-align: right;">
                                            <button type="button" class="btn btn-success aligh-right" id="addrow">
                                                Add New
                                            </button>
                                        </td>
                                    </tr>
                                    <tr style="background-color: darkblue;color: beige;">
                                        <td colspan="8" style="padding-top: 15px;"><span>Total</span></td>
                                        <td colspan="2"><input type="text" value="0" id="GrandTotal"
                                                class="form-control" disabled="">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="cal-md-12">
                            <label for="">Remark</label>
                            <textarea name="remark" class="form-control mb-3" id="" cols="30" rows="10">
                     {{ $editinfo->remark }}
                                                        </textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
