<div class="modal modal-danger fade" tabindex="-1" id="gallery_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-footer">
                @include('Admin.Product.manager')
                <div class="row">
                    <div class="col-md-12">
                        <div id="filemanager">
                            <media-manager
                                base-path="{{ config('food.media.path', '/') }}"
                                :show-folders="{{ config('food.media.show_folders', true) ? 'true' : 'false' }}"
                                :allow-upload="{{ config('food.media.allow_upload', true) ? 'true' : 'false' }}"
                                :allow-delete="{{ config('food.media.allow_delete', true) ? 'true' : 'false' }}"
                                :allow-create-folder="{{ config('food.media.allow_create_folder', true) ? 'true' : 'false' }}"
                                :allow-rename="{{ config('food.media.allow_rename', true) ? 'true' : 'false' }}"
                                :details="{{ json_encode(['thumbnails' => config('food.media.thumbnails', []), 'watermark' => config('food.media.watermark', (object)[])]) }}"
                            ></media-manager>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary pull-right add-gallery">
                    <i class="voyager-plus"></i>Add To Gallery
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    new Vue({
        el: '#filemanager'
    });

    // Delete gallery image
    function deleteGallery(input) {
        // Get remove item src
        let src = $(input).next().attr('src');

        // Update hidden gallery input filed
        let galleries = $('#gallery').val();
        let list = galleries.split(',');
        let filteredList = list.filter(function(e) { return e !== src });
        let res = filteredList.join(',');
        $('#gallery').val(res);

        // Remove gallery image
        $(input).parent().remove();
    }

    $('document').ready(function () {
        // Show gallery model
        $('#add_gallery').on('click', function(){
            $('#gallery_modal').modal('show');
        });

        // Add gallery
        $('.add-gallery').on('click', function() {
            // Get added image path
            let src = $('.detail_img div img').attr('src');

            // Update hidden gallery filed with images
            let galleries = $('#gallery').val();
            let newGallery = '';
            if(galleries == '') {
                newGallery = src;
            } else {
                newGallery = galleries.concat(',', src);
            }
            $('#gallery').val(newGallery);

            // Added images
            let str = '';
            str += '<li class="col-lg-3 col-sm-4 col-xs-6 image">';
            str += '<span class="gallery-trash" onclick="deleteGallery(this)">&times;</span>';
            str += '<img src="'+src+'">';
            str += '</li>';
            $('.product_images').append(str);
            $('#gallery_modal').modal('hide');

        });
    });
</script>
