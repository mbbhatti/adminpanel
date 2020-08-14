@extends('Layout.layout')

@section('title', (isset($id) ? 'Edit' : 'Add') . ' Page')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-file-text"></i>
        {{ (isset($id) ? 'Edit' : 'Add') . ' Page' }}
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
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="panel-body">
                            <div class="form-group">
                                {{ Form::label('template', 'Template') }}
                                {{ Form::select('template', $templates, old('template', $page->template ?? 'general'), array('class' => 'form-control select2')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('title', 'Title') }}
                                {{ Form::text('title', old('title', $page->title ?? ''), array('class' => 'form-control', 'id' => 'title', 'placeholder' => 'Title')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('slug', 'Slug') }}
                                {{ Form::text('slug', old('slug', $page->slug ?? ''), array('class' => 'form-control', 'id' => 'slug', 'placeholder' => 'Slug')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('excerpt', 'Excerpt') }}
                                {{ Form::textarea('excerpt', old('excerpt', $page->excerpt ?? ''), array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('content', 'Content') }}
                                {{ Form::textarea('content', old('content', $page->content ?? ''), array('class' => 'form-control richTextBox', 'id' => 'content')) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                <img id="image_preview" src="{{ isset($page->image) ? Storage::disk(config('storage.disk'))->url($page->image) : Storage::disk(config('storage.disk'))->url('pages/page1.jpg') }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                {{ Form::file('image', array('id' => 'image')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('status', 'Status') }}
                                {{ Form::select('status', $status, old('status', $page->status ?? 'INACTIVE'), array('class' => 'form-control select2')) }}
                            </div>
                            <div class="form-group meta">
                                {{ Form::label('meta_title', 'Meta Title') }}
                                {{ Form::text('meta_title', old('meta_title', $page->meta_title ?? ''), array('class' => 'form-control', 'placeholder' => 'Meta Title')) }}
                            </div>
                            <div class="form-group meta">
                                {{ Form::label('meta_description', 'Meta Description') }}
                                {{ Form::text('meta_description', old('meta_description', $page->meta_description ?? ''), array('class' => 'form-control', 'placeholder' => 'Meta Description')) }}
                            </div>
                            <div class="form-group meta">
                                {{ Form::label('meta_keywords', 'Meta Keywords') }}
                                {{ Form::text('meta_keywords', old('meta_keywords', $page->meta_keywords ?? ''), array('class' => 'form-control', 'placeholder' => 'Meta Keywords')) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary pull-right save">
                Save
            </button>
        {{ Form::close() }}
    </div>

    {{-- Tinymce content image upload --}}
    @include('Admin.Partial.upload', ['slug' => 'pages'])
@stop

@section('javascript')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/tinymce_config.js') }}"></script>
    <script src="{{ asset('assets/js/preview.js') }}"></script>
    <script src="{{ asset('assets/js/slug.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Template Meta setting
            let template = '{{$page->template}}';
            if(template != 'general') {
                $('.meta').hide();
            }

            $('#template').on('change', function (e) {
                let value = $.trim($(this).val());
                if(value == 'general') {
                    $('.meta').show();
                } else {
                    $('.meta').hide();
                }
            });

            // Tiny Mce Setting
            let additionalConfig = {
                selector: 'textarea.richTextBox[name="content"]',
            };
            tinymce.init(getConfig(additionalConfig));
        });
    </script>
@stop
