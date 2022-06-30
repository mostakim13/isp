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
                    <form action="{{ $store_url ?? '#' }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-1">
                                <label for="">Invoice Number :</label>
                                <input type="text" class="form-control mb-1" readonly name="invoice_no"
                                    value="{{$invoice_no}}">
                            </div>
                            <div class="col-md-3 mb-1">
                                <label for="">Date :</label>
                                <input type="date" class="form-control mb-1" value="{{date('Y-m-d')}}" name="date">
                            </div>
                            <div class="col-md-3 mb-1">
                                <label for="">Customer :</label>
                                <select name="customer_id" class="form-control mb-1">
                                    <option disabled selected>Select Customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-1">
                                <label for="">Staff:</label>
                                <select name="stuff_id" class="form-control mb-1">
                                    <option disabled selected>Select Stuff</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">

                            <div class="table-responsive">
                                <table class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Available Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="col-md-10">
                                                    <select id="category_item" class="form-control select2">
                                                        <option disabled selected>Select Category</option>
                                                        @foreach($categorys as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}
                                                            <span>({{$category->products_count}})</span>
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-10">
                                                    <select id="product_id" class="form-control select2">
                                                        <option disabled selected>Select Product</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-10">
                                                    <input type="number" class="form-control qty">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control available_qty" readonly
                                                        placeholder="Ex:1233">
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-info" type="button" id="add_item">Add
                                                    Item</button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <label for="">Note</label>
                                <textarea name="narration" class="form-control mb-1" id="" cols="30"
                                    rows="10"></textarea>
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

    $('#category_item').on('change', function () {
        let category_id = $(this).val();
        $.ajax({
            'url': "{{route('stockout.get.product')}}",
            'method': "GET",
            'dataType': "html",
            'data': {
                category_id: category_id
            },
            success: function (data) {
                $('#product_id option').remove();
                $('#product_id').append($(data));
                $("#product_id").trigger("select2:updated");
            }
        })
    })

    $('.qty').on('input', function () {
        let availableVal = $(this).parents('tr').find('.available_qty').val();
        let self = $(this);
        if (self.val() > Number(availableVal)) {
            alertMessage.error("The Quantity Not available");
            self.val(availableVal);
            return
        }
    })

    $('#product_id').on('change', function () {
        let product_id = $(this).val();
        $.ajax({
            'url': "{{route('stockout.get.quantity')}}",
            'method': "GET",
            'dataType': "html",
            'data': {
                product_id: product_id
            },
            success: function (data) {
                $('.available_qty').val(data)
                availableVal = data;
            }
        })
    })


    $(document).on('click', '#add_item', function () {

        let category = $('#category_item option:selected');

        let product = $('#product_id option:selected');

        let qty = $('.qty').val();
        let availableQty = $('.available_qty').val();

        if (!category) {
            alertMessage.error("Category Can't Not Be Null");
            return
        }
        if (!product) {
            alertMessage.error("Product Can't Not Be Null");
            return
        }
        if (!qty || qty == 0) {
            alertMessage.error("Quantity Can't Not Be Null");
            return
        }
        if (!availableQty || availableQty == 0) {
            alertMessage.error("Available Quantity Can't Not Be Null");
            return
        }

        // let productCheck = $('tbody').children('tr').attr('class', 'new_item' + product.val());
        // console.log($('.item_rows'))
        if ($('.item_rows' + product.val()).length > 0) {
            alertMessage.error("Product Already Added");

            return false;
        }


        const row = `
                    <tr class="item_rows${product.val()}">
                        <td style="padding-left:15px;">${category.text()}<input type="hidden" name="categorys[]" value="${category.val()}"></td>
                        <td class="text-right">${product.text()}<input type="hidden" class="add_quantity " product-id="${product.val()}" name="products[]" value="${product.val()}"></td>

                        <td class="text-right">${qty}<input type="hidden" class="form-control"  name="qty[]" value="${qty}"></td>

                        <td class="text-right">${availableQty}<input type="hidden" class="" name="available_qty[]" value="${availableQty}"></td>
                        <td>
                            <a del_id="${product.val()}" class="delete_item btn btn-danger" href="javascript:;" >
                                <i class="fa fa-times"></i>&nbsp;Remove
                            </a>
                        </td>
                    </tr>
                `;
        $("tbody").append(row);

        $('#category_item').prop('selectedIndex', 0);
        $('#product_id').prop('selectedIndex', 0);
        $('.qty').val("");
        $('.available_qty').val("");


    });

</script>
@endsection
