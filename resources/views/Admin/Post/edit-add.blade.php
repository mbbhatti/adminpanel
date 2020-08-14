@extends('Layout.layout')

@section('title', (isset($id) ? 'Edit' : 'Add') . ' Post')

@section('css')
    <link href="{{ asset('assets/css/post.css') }}" rel="stylesheet" type="text/css">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-news"></i>
        {{ (isset($id) ? 'Edit' : 'Add') . ' Post' }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        {{ Form::open([
            'url' => $route,
            'method' => 'POST',
            'class' => 'form-edit-add',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'autocomplete' => 'off'
            ])
        }}
            @if (isset($id))
                {{ method_field('PUT') }}
            @endif

            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-9">
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-character"></i> Post Title
                                <span class="panel-desc"> The title for your post</span>
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                {{ Form::text('title', old('title', $post->title ?? ''), array('class' => 'form-control', 'id' => 'title', 'placeholder' => 'Title')) }}
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Post Content</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::textarea('body', old('body', $post->body ?? ''), array('class' => 'form-control richTextBox')) }}
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Excerpt <small>Small description of this post</small></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            {{ Form::textarea('excerpt', old('excerpt', $post->excerpt ?? ''), array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> Post Details</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                {{ Form::label('slug', 'URL slug') }}
                                {{ Form::text('slug', old('slug', $post->slug ?? ''), array('class' => 'form-control', 'id' => 'slug', 'placeholder' => 'Slug')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('status', 'Post Status') }}
                                {{ Form::select('status', $status, old('status', $post->status ?? 'published'), array('class' => 'form-control select2')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('category_id', 'Post Category') }}
                                {{ Form::select('category_id', $categories, old('category_id', $post->category_id ?? ''), array('class' => 'form-control select2')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('featured', 'Featured') }}
                                {{ Form::checkbox('featured', 1, $post->featured ?? 0)  }}
                            </div>
                        </div>
                    </div>

                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Post Image</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @if(isset($post->image))
                                <img id="image_preview" src="{{ filter_var($post->image, FILTER_VALIDATE_URL) ? $post->image : Storage::disk(config('storage.disk'))->url($post->image) }}" style="width:100%" />
                            @else
                                <img id="image_preview" style="width:100%; height: 200px;" />
                            @endif
                            {{ Form::file('image', array('id' => 'image')) }}
                        </div>
                    </div>

                    <!-- ### SEO CONTENT ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> SEO Content</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                {{ Form::label('seo_title', 'SEO Title') }}
                                {{ Form::text('seo_title', old('seo_title', $post->seo_title ?? ''), array('class' => 'form-control', 'placeholder' => 'SEO Title')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('meta_description', 'Meta Description') }}
                                {{ Form::textarea('meta_description', old('meta_description', $post->meta_description ?? ''), array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('meta_keywords', 'Meta Keywords') }}
                                {{ Form::textarea('meta_keywords', old('meta_keywords', $post->meta_keywords ?? ''), array('class' => 'form-control')) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary pull-right save">
                @if (isset($id))
                    Update Post
                @else
                    Create New Post
                @endif
            </button>
        {{ Form::close() }}
    </div>

    {{-- Tinymce content image upload --}}
    @include('Admin.Partial.upload', ['slug' => 'posts'])

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> Are you sure</h4>
                </div>

                <div class="modal-body">
                    <h4>Are you sure you want to delete '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">Yes, Delete it!</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('javascript')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/tinymce_config.js') }}"></script>
    <script src="{{ asset('assets/js/preview.js') }}"></script>
    <script src="{{ asset('assets/js/slug.js') }}"></script>
    <script type="text/javascript">
        let params = {};
        let $file;

        function deleteHandler(tag, isMulti) {
            return function() {
                $file = $(this).siblings(tag);

                params = {
                    slug:   'posts',
                    filename:  $file.data('file-name'),
                    id:     $file.data('id'),
                    field:  $file.parent().data('field-name'),
                    multi: isMulti,
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text(params.filename);
                $('#confirm_delete_modal').modal('show');
            };
        }

        $('document').ready(function () {
            // Default hide right panel
            $('.panel-bordered .voyager-angle-down').addClass('panel-collapsed');

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('post.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();

            // Tiny MCE Setting
            let additionalConfig = {
                selector: 'textarea.richTextBox[name="body"]',
            };
            tinymce.init(getConfig(additionalConfig));
        });
    </script>
@stop
