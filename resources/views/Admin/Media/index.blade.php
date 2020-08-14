@extends('Layout.layout')

@section('title', 'Media')

@section('head')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')
    @include('Admin.Media.manager')
    <div class="page-content container-fluid">
        @include('Admin/Partial/alerts')
        <div class="row">
            <div class="col-md-12">

                <div class="admin-section-title">
                    <h3><i class="voyager-images"></i> Media</h3>
                </div>
                <div class="clear"></div>
                <div id="filemanager">
                    <media-manager
                        base-path="{{ config('food.media.path', '/') }}"
                        :show-folders="{{ config('food.media.show_folders', true) ? 'true' : 'false' }}"
                        :allow-upload="{{ config('food.media.allow_upload', true) ? 'true' : 'false' }}"
                        :allow-move="{{ config('food.media.allow_move', true) ? 'true' : 'false' }}"
                        :allow-delete="{{ config('food.media.allow_delete', true) ? 'true' : 'false' }}"
                        :allow-create-folder="{{ config('food.media.allow_create_folder', true) ? 'true' : 'false' }}"
                        :allow-rename="{{ config('food.media.allow_rename', true) ? 'true' : 'false' }}"
                        :allow-crop="{{ config('food.media.allow_crop', true) ? 'true' : 'false' }}"
                        :details="{{ json_encode(['thumbnails' => config('food.media.thumbnails', []), 'watermark' => config('food.media.watermark', (object)[])]) }}"
                        ></media-manager>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        new Vue({
            el: '#filemanager'
        });
    </script>
@endsection
