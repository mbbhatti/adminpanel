$(document).ready(function() {
    // Image Preview Setting
    $("#image, #avatar").change(function() {
        let input = this;
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('#image_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    });
});
