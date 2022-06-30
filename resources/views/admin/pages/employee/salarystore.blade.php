<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b class="salaryby"></b>`s Salary</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="row md-3">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item active">Salary : <span class="salaryval"></span></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item active">Paidable : <span class="paidable"></span></li>
                        </ul>
                    </div>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 md-3">
                            <label for="">Date</label>
                            <input type="month" class="form-control" name="date">
                        </div>

                        <div class="col-md-6 md-3">
                            <label for="">Amount</label>
                            <input type="number" name="amount" class="form-control ">
                        </div>
                        <div class="col-md-12 md-3">
                            <label for="">Note</label>
                            <textarea name="note" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-md-6 md-3 d-none">
                            <input type="text" name="emid" class="form-control emid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).on('click', '.salaryModel', function (e) {
        e.preventDefault();
        $('.bd-example-modal-lg').modal('toggle');
        let url = $(this).attr('href');
        $.ajax({
            "url": url,
            "method": "GET",
            success: function (data) {
                $('.emid').val(data.data.id);
                // text
                $('.salaryby').text(data.data.name);
                $('.salaryval').text(data.data.salary);
                $('.paidable').text(data.data.paidable);

            }
        })

    })

    // salary_amount
    // $(document).on('input', '.salary_amount', function () {
    //     let salary = $('.salaryval').val();
    //     if (salary < $(this).val()) {
    //         $(this).val('');
    //         alert('You add extra amount');
    //     }
    // })
</script>
@endsection('scripts')
