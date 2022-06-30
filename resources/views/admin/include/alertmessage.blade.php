<script>
    $(function () {
        'use strict';
        $(document).on('click', '.switchUrl', function () {
            let status = $(this).attr('url');
            var table = $('#server_side_lode').DataTable();
            let url =
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to change status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: status,
                            type: 'GET',
                            success: function (data) {
                                console.log(data);
                                if (data.code == 203) {
                                    Swal.fire(
                                        'Warning!',
                                        'Your status id must be numeric.',
                                        'success'
                                    )
                                } else if (data.code == 404) {
                                    Swal.fire(
                                        'Warning!',
                                        'Your status info not found.',
                                        'warning'
                                    )
                                } else {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Your data successfully deleted!!'
                                    })
                                }
                                // Swal.fire(
                                //     'Deleted!',
                                //     'Your file has been deleted.',
                                //     'success'
                                // )

                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated',
                            text: 'Status Updated Successfully!',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                        table.ajax.reload();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            // text: 'Status Not Updated :)',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                        table.ajax.reload();
                    }
                });
        });


    });
    function sweetalert() {
        function error($message) {
            Swal.fire({
                title: 'Error!',
                text: $message,
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        }
        sweetalert.error = error;
    }
    sweetalert();

</script>
