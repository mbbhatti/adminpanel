let getConfig = function(options) {

    let baseTinymceConfig = {
        menubar: false,
        selector: 'textarea.richTextBox',
        skin_url: '/assets/js/skins/lightgray',
        min_height: 200,
        resize: 'vertical',
        plugins: 'textcolor, lists',
        toolbar: 'styleselect bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent',
        convert_urls: false,
        image_caption: true,
        image_title: true
    };

    return $.extend({}, baseTinymceConfig, options);
};
