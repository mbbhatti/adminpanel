@extends('Layout.layout')

@section('title', ' Banner')

@section('css')
    <link href="{{ asset('assets/css/post.css') }}" rel="stylesheet" type="text/css">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-images"></i>
        Banner
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-8">
                {{-- Upload image --}}
                @include('Admin.Banner.gallery')
            </div>
            <div class="col-md-4">
                {{ Form::open([
                    'url' => 'admin/banners/create',
                    'method' => 'POST',
                    'class' => 'form-edit-add',
                    'role' => 'form',
                    'enctype' => 'multipart/form-data',
                    'autocomplete' => 'off'
                    ])
                }}
                    {{ csrf_field() }}
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> Slider Gallery</h3>
                        </div>
                        <div class="panel-body" style="display: block;">
                            <div class="product_images_container">
                                <ul class="product_images ui-sortable">
                                    @if(isset($banners) > 0)
                                        @foreach ($banners as $banner)
                                            <li class="col-lg-3 col-sm-4 col-xs-6 image">
                                                <span class="gallery-trash" onclick="deleteGallery(this)">&times;</span>
                                                <img src="{{ $banner->image }}">
                                                <input type="hidden" name="image[]" value="{{ $banner->image }}">
                                                <input type="text" class="form-control" name="caption[]" value="{{ $banner->caption ?? '' }}">
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" id="btn-slider" style="width: 100%; display: none;">
                        <span>Update</span>
                    </button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('assets/js/preview.js') }}"></script>
@stop

