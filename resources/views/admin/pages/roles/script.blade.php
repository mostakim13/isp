<script type="text/javascript">
    let table = $('#systemDatatable').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": "{{ route('roles.dataProcessing') }}",
        "dataType": "json",
        "type": "GET",
        "data": {
            "_token": "<?= csrf_token() ?>"
        }
    },
    "columns": [{
            "data": "id",
            "orderable": true
        },
        {
            "data": "role_name",
            "orderable": true
        },

        {
            "data": "status",
            "orderable": false,
            "class": 'text-nowrap',
        },
        {
            "data": "action",
            "class": 'text-nowrap',
            "searchable": false,
            "orderable": false
        },
    ],

    "fnDrawCallback": function() {
        $("[name='my-checkbox']").bootstrapSwitch({
            size: "small",
            onColor: "success",
            offColor: "danger"
        });
    },

});


var buttons = new $.fn.dataTable.Buttons(table, {
    buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
        'print',
    ]
}).container().appendTo($('#buttons'));
</script>








<script>
    $(function() {
    /**
     * Check all the permissions
     */
    $(".checkPermissionAll").click(function() {

        if ($(this).is(':checked')) {
            // check all the checkbox
            $('input[type=checkbox]').prop('checked', true);
        } else {
            // un check all the checkbox
            $('input[type=checkbox]').prop('checked', false);
        }
    });

    $(".submenu").click(function() {
        let id = $(this).attr('serial_id');
        if ($(".submenu_" + id).is(':checked')) {
            $('.child_menu_' + id).prop('checked', true);
        } else {
            $('.child_menu_' + id).prop('checked', false);
        }
    });


    function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
        const classCheckbox = $('.' + groupClassName + ' input');
        const groupIDCheckBox = $("#" + groupID);

        // if there is any occurance where something is not selected then make selected = false
        if ($('.' + groupClassName + ' input:checked').length == countTotalPermission) {
            groupIDCheckBox.prop('checked', true);
        } else {
            groupIDCheckBox.prop('checked', false);
        }
        implementAllChecked();
    }

});
</script>
