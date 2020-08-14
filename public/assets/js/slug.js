$(document).ready(function() {
    // Slug Setting
    $('#title').on('keyup change', function (e) {
        let str = $(this).val();
        let trimmed = $.trim(str);
        let $slug = trimmed.replace(/[^a-z0-9-]/gi, '-') . replace(/-+/g, '-') . replace(/^-|-$/g, '');
        $('#slug').val($slug.toLowerCase());
    });
});
