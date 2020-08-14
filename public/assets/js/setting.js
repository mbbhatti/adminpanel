$('document').ready(function () {
    $('#toggle_options').click(function () {
        $('.new-settings-options').toggle();
        if ($('#toggle_options .voyager-double-down').length) {
            $('#toggle_options .voyager-double-down').removeClass('voyager-double-down').addClass('voyager-double-up');
        } else {
            $('#toggle_options .voyager-double-up').removeClass('voyager-double-up').addClass('voyager-double-down');
        }
    });

    $('.toggleswitch').bootstrapToggle();

    $('[data-toggle="tab"]').click(function() {
        $(".setting_tab").val($(this).html());
    });

    $('.delete_value').click(function(e) {
        e.preventDefault();
        $(this).closest('form').attr('action', $(this).attr('href'));
        $(this).closest('form').submit();
    });

    // Setting rich text editor
    let additionalConfig = {
        selector: 'textarea.richTextBox',
    };
    tinymce.init(getConfig(additionalConfig));

    $(".group_select").not('.group_select_new').select2({
        tags: true,
        width: 'resolve'
    });
    $(".group_select_new").select2({
        tags: true,
        width: 'resolve',
        placeholder: 'Select Existing Group or Add New'
    });
    $(".group_select_new").val('').trigger('change');
});
