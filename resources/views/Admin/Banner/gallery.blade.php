<div class="panel panel-bordered panel-primary">
    @include('Admin.Banner.manager')
    <div id="filemanager" class="panel">
        <media-manager
            base-path="{{ config('food.media.path', '/') }}"
            :show-folders="{{ config('food.media.show_folders', true) ? 'true' : 'false' }}"
            :allow-upload="{{ config('food.media.allow_upload', true) ? 'true' : 'false' }}"
            :allow-delete="{{ config('food.media.allow_delete', true) ? 'true' : 'false' }}"
            :allow-create-folder="{{ config('food.media.allow_create_folder', true) ? 'true' : 'false' }}"
            :allow-rename="{{ config('food.media.allow_rename', true) ? 'true' : 'false' }}"
            :details="{{ json_encode(['thumbnails' => config('food.media.thumbnails', []), 'watermark' => config('food.media.watermark', (object)[])]) }}"
        ></media-manager>
        <button type="button" class="btn btn-primary pull-right add-gallery">
            <i class="voyager-plus"></i>Add To Gallery
        </button>
    </div>
</div>

<script type="text/javascript">
    new Vue({
        el: '#filemanager'
    });

    // Delete gallery image
    function deleteGallery(input) {
        // Remove gallery image
        $(input).parent().remove();

        // Check images and hide button
        toggleUpdate();
    }

    function toggleUpdate() {
        let length = $('.product_images').find('li').length;
        if(length > 0) {
            $('#btn-slider').show();
        } else {
            $('#btn-slider').hide();
        }
    }

    $('document').ready(function () {
        // Check images and hide button
        toggleUpdate();

        // Add gallery
        $('.add-gallery').on('click', function() {
            // Get added image path
            let src = $('.detail_img div img').attr('src');

            // Added images
            let str = '';
            str += '<li class="col-lg-3 col-sm-4 col-xs-6 image">';
            str += '<span class="gallery-trash" onclick="deleteGallery(this)">&times;</span>';
            str += '<img src="'+src+'">';
            str += '<input type="hidden" name="image[]" value="'+src+'">';
            str += '<input type="text" class="form-control" name="caption[]" value="">';
            str += '</li>';
            $('.product_images').append(str);

            // Check images and hide button
            toggleUpdate();
        });
    });
</script>
