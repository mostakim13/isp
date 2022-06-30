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
                            <div class="col-md-3 mb-3">
                                <label>Invoice Number :</label>
                                <input class="form-control" readonly=""
                                    style="padding: 5px; font-weight : bold; width: 100%"
                                    value="{{ $editinfo->invoice_no }} ">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Date:</label>
                                <div class="input-group">
                                    <input type="date" name="date" value="{{$editinfo->date}}" class="form-control" />
                                </div>
                                @error('date')
                                <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Supplier * :</label>
                                <select class="form-control select2 supid" name="supplier_id">
                                    <option selected disabled value="">--Select Supplier--</option>
                                    @foreach ($supplier as $key => $value)
                                    <option {{$editinfo->supplier_id == $value->id ? "selected":"" }} value="{{
                                        $value->id }}">
                                        {{ $value->supplierCode . ' - ' . $value->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label>Payment Type * :</label>
                                    <select class="form-control select2 payment_type" name="payment_type">
                                        <option selected disabled value="">--Payment Type--</option>
                                        <option {{$editinfo->payment_type == "cash" ? "selected":"" }}
                                            value="cash">Account
                                        </option>
                                        <!-- <option value="check">Check</option> -->
                                        <option {{$editinfo->payment_type == "due" ? "selected":"" }} value="due">Due
                                        </option>
                                    </select>
                                    @error('payment_type')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if ($editinfo->payment_type == 'cash')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account</label>
                                        <select name="accounts" class="form-control select2 accounts">
                                            <option value='' selected disabled>--Select Account--</option>
                                            @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $editinfo->account_id ==
                                                $account->id ? 'selected' : '' }}>
                                                {{ $account->accountCode }} - {{ $account->account_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Balance</label>
                                        <input name="balance" type="text" class="form-control balance"
                                            placeholder="Ex:31424" value="{{ $remainingBalance ?? 0 }}" readonly />
                                    </div>
                                </div>
                            </div>

                            @endif


                            {{-- html load by js --}}
                            <div class="account-section col-md-12"></div>

                            <table class="table table-bordered table-hover" id="show_item">
                                <thead>
                                    <tr>
                                        <th colspan="8">Select Product Item</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><strong>Category</strong></td>
                                        <td class="text-center" width="20%"><strong>Product</strong></td>
                                        <td class="text-center"><strong>Quantity</strong></td>
                                        <td class="text-center"><strong>Unit Price</strong></td>
                                        <td class="text-center"><strong>Total</strong></td>
                                        <td class="text-center"><strong>Action</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select onchange="getProductList(this.value)"
                                                class="select2 form-control catName reset" id="form-field-select-3"
                                                data-placeholder="Search Category">
                                                <option disabled selected>---Select Category---</option>
                                                @foreach ($category_info as $eachInfo)
                                                <option catName="{{ $eachInfo->name }}" value="{{ $eachInfo->id }}">
                                                    {{ $eachInfo->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="select2 form-control proName reset" id="productID"
                                                data-placeholder="Search Product" onchange="getUnitPrice(this.value)">
                                                <option disabled selected>---Select Product---</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step="any"
                                                class="form-control text-right qty reset_qty" placeholder="Qty" min="0">
                                        </td>
                                        <td>
                                            <input type="number" step="any" min="0" id="unitprice"
                                                class="form-control text-right unitprice reset_unitprice"
                                                placeholder="Unit Price">
                                        </td>
                                        <td>
                                            <input type="number" step="any" readonly
                                                class="form-control text-right total reset_total" id="total"
                                                placeholder="Total">
                                        </td>
                                        <td>
                                            <a id="add_item" class="btn btn-info" style="white-space: nowrap"
                                                href="javascript:;" title="Add Item">
                                                <i class="fa fa-plus"></i>
                                                Add Item
                                            </a>
                                        </td>
                                    </tr>
                                    @foreach ($editinfo->details as $detail)
                                    <input type="hidden" class="add_quantity" name="oldproName[]"
                                        value="{{ $detail->productlist->id ?? '' }}">
                                    <input type="hidden" class="ttlqty" name="oldqty[]" value="{{ $detail->quantity }}">

                                    <tr class="new_item{{ $detail->productlist->id ?? '' }}">
                                        <td style="padding-left:15px;">
                                            {{ $detail->productlist->category->name ?? '' }}
                                            <input type="hidden" name="catName[]"
                                                value="{{ $detail->productlist->category->id ?? '' }}">
                                        </td>
                                        <td class="text-right">
                                            {{ $detail->productlist->name ?? '' }}
                                            <input type="hidden" class="add_quantity" name="proName[]"
                                                value="{{ $detail->productlist->id ?? '' }}">
                                        </td>

                                        <td class="text-right">
                                            {{ $detail->quantity }}
                                            <input type="hidden" class="ttlqty" name="qty[]"
                                                value="{{ $detail->quantity }}">
                                        </td>
                                        <td class="text-right">
                                            {{ $detail->unit_price }}
                                            <input type="hidden" class="ttlunitprice" name="unitprice[]"
                                                value="{{ $detail->unit_price }}">
                                        </td>
                                        <td class="text-right">
                                            {{ $detail->total_price }}
                                            <input type="hidden" class="total" name="total[]"
                                                value="{{ $detail->total_price }}">
                                        </td>
                                        <td>
                                            <a del_id="${proId}" class="delete_item btn  btn-danger"
                                                href="javascript:;">

                                                <i class="fa fa-times"></i>&nbsp;Remove
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right"><strong>Sub-Total(BDT)</strong></td>
                                        <td class="text-right"><strong class=""></strong></td>
                                        <td class="text-right"><strong class="ttlqty"></strong>
                                        </td>
                                        <td class="text-right"><strong class="ttlunitprice"></strong></td>
                                        <td class="text-right"><strong class="grandtotal"></strong></td>
                                        <td class="text-right"><strong class=""></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group">
                                        <textarea cols="100" rows="3" class="form-control" name="narration"
                                            placeholder="Narration" type="text">
                                            {{$editinfo->narration}}
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <input type="hidden" name="cart_vat" class="input_vat">
                                <input type="hidden" name="input_net_total" class="input_net_total">
                                <input type="hidden" name="cart_due" class="input_due">

                                <table class="table table-bordered table-hover" id="cart_output">
                                    <tr>
                                        <th><span>Total</span></th>
                                        <th class="text-right"><span class="grandtotal"></span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th><span>Discount(-)</span></th>
                                        <th class="text-right">
                                            <input type="number" step="any" class="form-control discount input-checker"
                                                name="discount" placeholder="Ex:5">
                                            @error('discount')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </th>
                                    </tr>
                                    {{-- <tr>
                                        <th><span>Vat</span></th>
                                        <th class="text-right">
                                            <input type="number" step="any" class="form-control vat input-checker"
                                                name="vat" placeholder="Ex:5" readonly>
                                            @error('vat')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </th>
                                    </tr> --}}
                                    <tr>
                                        <th><span>Net Total</span></th>
                                        <th class="text-right"><span class="cart_net_total"></span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th><span>Payment(-) *</span></th>
                                        <th class="text-right">
                                            <input type="number" {{$editinfo->payment_type == "cash" ? "readonly":"" }}
                                            step="any" id="paymentTypeCheck"
                                            class="form-control paid_amount input-checker"
                                            value="{{$editinfo->paid_amount}}" name="paid_amount"
                                            placeholder="Ex:5">
                                            <div class="payment_amount_error"></div>
                                            @error('paid_amount')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </th>
                                    </tr>
                                    <tr id="duevalid">
                                        <th><span>Total Due</span></th>
                                        <th class="text-right"><span class="cart_due"></span>
                                        </th>
                                    </tr>
                                </table>
                                <!-- /.card -->
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
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
    $(document).ready(function () {
        findgrandtottal();
        var findqtyamoun = function () {

            var ttlqty = 0;
            $.each($('.ttlqty'), function () {
                qty = number_format($(this).val());
                ttlqty += qty;
            });
            $('.ttlqty').text(number_format(ttlqty));

        };

        var findunitamount = function () {
            var ttlunitprice = 0;
            $.each($('.ttlunitprice'), function () {
                unitprice = number_format($(this).val());
                ttlunitprice += unitprice;
            });
            $('.ttlunitprice').text(number_format(ttlunitprice));
        };


        $(document).on('click', '#add_item', function () {

            var parent = $(this).parents('tr');

            var supid = $('.supid').val();
            var catId = $('.catName').val();

            var catName = $(".catName").find('option:selected').attr('catName');

            //            var subcatID = $('.subCat').val();
            //            var subCat = $(".subCat").find('option:selected').attr('subCat');

            var proId = $('.proName').val();
            var proName = $(".proName").find('option:selected').attr('proName');

            //            var unit_id = $('.unitName').val();
            //            var unitName = $(".unitName").find('option:selected').attr('unitName');

            //  var unit = $('.unit').val();
            var qty = number_format(parent.find('.qty').val());



            var unitprice = number_format(parent.find('.unitprice').val());

            // start check duplicate product
            let seaschproduct = $('#productID option:selected')[0].getAttribute("value");
            let tbody = $('tbody').find(".new_item" + seaschproduct).length;
            let tbody2 = $('tbody').find("new_item" + seaschproduct);
            console.log(tbody);

            if (tbody > 0) {
                alertMessage.error('This product already exist');
                return;
            }
            // end check duplicate product


            if (supid == '' || supid == null) {
                alertMessage.error("Supplier can't be empty.");
                return false;
            }
            if (catId == '' || catId == null) {
                alertMessage.error("Category can't be empty.");
                return false;
            }
            if (proId == '' || proId == null) {
                alertMessage.error("Product can't be empty.");
                return false;
            }


            if (qty == '' || qty == null || qty == 0) {
                alertMessage.error('Quantity cannot be empty');
                return false;
            } else {
                var total = qty * unitprice;

                var grandtotal = 0;

                $.each($('.checktotal'), function (index, item) {

                    totaltt = number_format($(item).val());
                    grandtotal += totaltt;
                });

                let accountAmountCheck = total + grandtotal;

                let paymenttypes = $('.payment_type').val();

                if (paymenttypes != null) {
                    if (paymenttypes.toLowerCase() == 'cash') {
                        var balance = $('.balance').val();
                        var account = $('.accounts').val();
                        if (account != null) {
                            if (accountAmountCheck >= balance) {
                                alertMessage.error(
                                    'purchase product amount can not greater than account balance');
                                return;
                            }
                        } else {
                            alertMessage.error('Please Select Your payment Account');
                            return
                        }
                    } else if (paymenttypes.toLowerCase() == "check") {
                        var accountnum = $('.accountnum').val();
                        var checknum = $('.checknum').val();
                        var banknum = $('.banknum').val();
                        var bankbranchnum = $('.bankbranchnum').val();

                        if ((accountnum == "") || (checknum == "") || (banknum == "") || (
                            bankbranchnum == "")) {
                            alertMessage.error('Please Enter Your Check Information');
                            return
                        }

                    }
                } else {
                    alertMessage.error('Please Complete your basic required field');
                    return
                }


                const row = `
                    <tr class="new_item${proId}">
                        <td style="padding-left:15px;">${catName}<input type="hidden" name="catName[]" value="${catId}"></td>
                        <td class="text-right">${proName}<input type="hidden" class="add_quantity" name="proName[]" value="${proId}"></td>

                        <td class="text-right">${qty}<input type="hidden" class="ttlqty" name="qty[]" value="${qty}"></td>
                        <td class="text-right">${unitprice}<input type="hidden" class="ttlunitprice" name="unitprice[]" value="${unitprice}">
                        </td>
                        <td class="text-right">${total}
                            <input type="hidden" class="total" name="total[]" value="${total}">
                        </td>
                        <td>
                            <a del_id="${proId}" class="delete_item btn  btn-danger" href="javascript:;" title="">
                                <i class="fa fa-times"></i>&nbsp;Remove
                            </a>
                        </td>
                    </tr>
                `;
                $("#show_item tbody").append(row);
            }

            $('.reset_unitprice').val('');
            $('.reset_qty').val('');
            $('.reset_total').val('');
            $(".reset").val(null).trigger("change");

            findqtyamoun();
            findunitamount();
            findgrandtottal();
        });

        $(document).on('click', '.delete_item', function () {

            let deleteitem = () => {
                $(this).parents('tr').remove();
                findqtyamoun();
                findunitamount();
                findgrandtottal();
            }

            alertMessage.confirm('You want to remove this', deleteitem);
        });

        // check payment type by joy
        $(document).on('change', '.payment_type', function () {
            const self = $(this);
            const val = self.val();

            if (val == '' || val == null || val == 0) {
                return false;
            }
            checkTypeAndGetAccountInfo(val);

        });

        // get account balance and show by html
        $(document).on('change', '.accounts', function () {
            // settings.transfer.checkBalance
            const self = $(this);
            const val = self.val();

            if (val == '' || val == null || val == 0) {
                return false;
            }
            getBalance(val);
        });

        // Quantity price calculate
        $(document).on('input', '.qty', function () {
            let self = $(this);
            let parent = self.parents('tr');
            let qty = number_format(self.val());

            if (qty == '' || qty == null) {
                $(this).val(1);
                qty = 1;
            }

            let unitPrice = number_format(parent.find('.unitprice').val());

            let total = number_format(unitPrice * qty);

            parent.find('.total').val(number_format(total));

        });

        $(document).on('input', '.input-checker', function () {
            var grandtotal = $('.grandtotal').text();
            grandtotal = Number(grandtotal);

            if (isNaN(grandtotal) || grandtotal < 1) {
                // lert('Please Add some item first.');
                alertMessage.error('Please Add some item first.');
                return false;
            }
            findgrandtottal();

        });

        if ($('.payment_type').val() == '' || $('.payment_type').val() == null) {
            $('#submit').prop('disabled', true);
            $('.paid_amount').prop('readonly', true);
        } else {
            $('.paid_amount').prop('readonly', false);

        }

        $(document).on('change', '.payment_type', function () {
            let payment_type = $(this).val();
            if (payment_type == '' || payment_type == null) {
                $('#submit').prop('disabled', true);
                $('.paid_amount').prop('readonly', true);
            } else {
                $('.paid_amount').prop('readonly', false);
            }

        });

        $(document).on('keyup', '.paid_amount', function () {
            let paidAmount = number_format($(this).val());
            let balance = number_format($('.balance').val());
            console.log(balance)
            let paymentType = $('.payment_type').val();

            if (paymentType.toLowerCase() == 'cash' && balance < paidAmount) {
                $('#submit').prop('disabled', true);

                $('.payment_amount_error').html(
                    '<span class="error text-red text-bold">Payed amount cannot be greater then balance.</span>'
                );

            } else {
                $('#submit').prop('disabled', false);
                $('.payment_amount_error').html('')
            }
        });

    });


    function findgrandtottal() {
        var grandtotal = 0;

        $.each($('.total'), function (index, item) {

            total = number_format($(item).val());
            grandtotal += total;
        });

        // let vatE = $('.vat');
        let discountE = $('.discount');
        let paidAmountE = $('.paid_amount');

        let vat = 0; //number_format(vatE.val());
        let discount = number_format(discountE.val());
        let paidAmount = number_format(paidAmountE.val());

        //calculate discount
        let cal_vat = percentageCalculate(grandtotal, vat);


        let cal_grandtotal = grandTotalCalculate(grandtotal, discount, cal_vat);
        let cal_due = dueCalculate(cal_grandtotal, paidAmount);

        let cart_net_total = $('.cart_net_total');
        let cart_due = $('.cart_due');

        $('.grandtotal').text(number_format(grandtotal));
        cart_net_total.text(cal_grandtotal);
        cart_due.text(cal_due);


        $('.input_vat').val(cal_vat);
        $('.input_net_total').val(cal_grandtotal);
        $('.input_due').val(cal_due);


    };

    function dueCalculate(amount, paid_amount) {
        return number_format(number_format(amount) - number_format(paid_amount));
    }

    function grandTotalCalculate(total, discount = 0, vat = 0, result = 0) {
        result = (total + vat) - discount;
        return number_format(result);

    }

    function percentageCalculate(amount, disc) {
        return number_format(amount * disc * .01);
    }

    function number_format(number, decimal = 2) {
        number = Number(number);
        return Number(parseFloat(number).toFixed(decimal));
    }

    function getProductList(cat_id) {
        if (cat_id == '' || cat_id == null || cat_id == 0) {
            return false;
        }
        $.ajax({
            "url": "{{ route('purchases.get.product') }}",
            "type": "GET",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                cat_id: cat_id
            },
            success: function (data) {
                $('#productID').select2();
                $('#productID option').remove();
                $('#productID').append($(data));
                $("#productID").trigger("select2:updated");
            }
        });
    }

    function getUnitPrice(productId) {

        if (productId == '' || productId == null || productId == 0) {
            return false;
        }

        $.ajax({
            "url": "{{ route('purchases.unitPice') }}",
            "type": "GET",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                productId: productId
            },
            success: function (data) {
                $("#unitprice").val(data);
            }
        });
    }

    //
    function checkTypeAndGetAccountInfo(type) {
        if (type == "cash") {
            $.ajax({
                "url": "{{ route('purchases.accounts') }}",
                "type": "GET",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    let html = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account</label>
                                <select name="chart_of_account_id" class="form-control select2 accounts">
                                    ${data}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Balance</label>
                                <input name="balance" type="text" class="form-control balance" placeholder="Ex:31424" readonly />
                            </div>
                        </div>
                    </div>
                    `;
                    $('.account-section').html(html);
                    $('.accounts').select2();
                }
            });
        } else if (type == "check") {
            let html = `<div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Account Number</label>
                        <input name="account_number" type="text" class="form-control" placeholder="Ex:1234234" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Check Number</label>
                        <input name="check_number" type="text" class="form-control" placeholder="Ex:31424" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <input name="bank" type="text" class="form-control" placeholder="Ex:Bank Of Asia" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Branch Name</label>
                        <input name="bank_branch" type="text" class="form-control" placeholder="Ex:Dhaka" />
                    </div>
                </div>
            </div>
            `;
            $('.account-section').html(html);
        } else {
            let html = '';
            $('.account-section').html(html);
        }
    }
    getBalance("{{$editinfo->account_id}}");
    //get balance of selected account
    function getBalance(account_id) {
        $.ajax({
            'url': "{{route('purchases.getBalance')}}",
            "type": "GET",
            cache: false,
            data: {
                // "_token": "{{ csrf_token() }}",
                account_id: account_id
            },
            success: function (data) {
                $('.balance').val(data);
            }
        });

    }
</script>
@endsection
