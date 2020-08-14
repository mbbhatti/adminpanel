let getConfig = function(options) {

    let baseTinymceConfig = {
        menubar: false,
        selector: 'textarea.richTextBox',
        skin_url: '/assets/js/skins/lightgray',
        min_height: 300,
        resize: 'vertical',
        plugins: 'link, image, code, table, textcolor, lists',
        extended_valid_elements : 'input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]',
        file_browser_callback: function(field_name, url, type) {
            if (type =='image') {
                $('#upload_file').trigger('click');
            }
        },
        toolbar: 'styleselect bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image table | code',
        convert_urls: false,
        image_caption: true,
        image_title: true,
        init_instance_callback: function (editor) {
            if (typeof tinymce_init_callback !== "undefined") {
                tinymce_init_callback(editor);
            }
        },
        setup: function (editor) {
            if (typeof tinymce_setup_callback !== "undefined") {
                tinymce_setup_callback(editor);
            }
        }
    };

    return $.extend({}, baseTinymceConfig, options);
};
