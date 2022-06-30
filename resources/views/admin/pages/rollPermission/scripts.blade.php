<script>
    $(function () {
        /**
         * Check all the permissions
         */
        $(".checkPermissionAll").click(function () {

            if ($(this).is(':checked')) {
                // check all the checkbox
                $('input[type=checkbox]').prop('checked', true);
            } else {
                // un check all the checkbox
                $('input[type=checkbox]').prop('checked', false);
            }
        });

        $(".submenu").click(function () {
            let id = $(this).attr('serial_id');
            if ($(".submenu_" + id).is(':checked')) {
                $('.child_menu_' + id).prop('checked', true);
            } else {
                $('.child_menu_' + id).prop('checked', false);
            }
        });
        $(".childmenu").click(function () {
            let id = $(this).attr('serial_id');
            if ($(".child_menu_" + id).is(':checked')) {
                $('.submenu_' + id).prop('checked', true);
            } else {
                $('.submenu_' + id).prop('checked', false);
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
