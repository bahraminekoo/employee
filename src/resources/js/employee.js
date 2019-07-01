$(document).ready(function() {
    $('button#show_grid_filters').on('click', function () {
        $('.hidden-filters').toggle();
    });

    $('a[id^="employee_view_"]').on('click', function(e) {
        e.preventDefault();
        let employee_id = $(this).data('employee-id');
        let modal = $('#employee_modal_' + employee_id);
        modal.css({display: 'block'});

        $(window).on('click', function (event) {
            if (event.target == modal) {
                modal.css({display: 'none'});
            }
        });
    });

    $("span[id^='employee_modal_close_']").on('click', function() {
        let employee_id = $(this).data('employee-id');
        $(this).closest('#employee_modal_' + employee_id).css({display: 'none'});
    });

    $('a[id^="employee-delete-"]').on('click', function(e) {
        if(!confirm('Are you sure you want to delete this item?')) {
            return false;
        }
        e.preventDefault();
        let employee_id = $(this).data('employee-id');
        $('#employee-delete-form-'+employee_id).submit();
    });
});