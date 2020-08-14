@extends('Layout.layout')

@section('title', (isset($id) ? 'Edit' : 'Add') . ' Product')

@section('css')
    <link href="{{ asset('assets/css/post.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-news"></i>
        {{ (isset($id) ? 'Edit' : 'Add') . ' Product' }}
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
                        <div class="panel-body">
                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', old('name', $product->name ?? ''), array('class' => 'form-control', 'placeholder' => 'Name')) }}
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-body">
                            {{ Form::label('description', 'Description') }}
                            {{ Form::textarea('description', old('description', $product->description ?? ''), array('class' => 'form-control richTextBox')) }}
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-body">
                            {{ Form::label('excerpt', 'Product short description') }}
                            {{ Form::textarea('excerpt', old('excerpt', $product->excerpt ?? ''), array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <!-- ### Save button ### -->
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success" style="width: 100%">
                                <span>Publish</span>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('products') }}" class="btn btn-danger" style="width: 100%">
                                <span>Cancel</span>
                            </a>
                        </div>
                    </div>

                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> Product Details</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                {{ Form::label('status', 'Product Status') }}
                                {{ Form::select('status', $status, old('status', $product->status ?? 'published'), array('class' => 'form-control select2')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('category_id', 'Product Category') }}
                                {{ Form::select('category_id', $categories, old('category_id', $product->category_id ?? ''), array('class' => 'form-control select2')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('featured', 'Product Featured') }}
                                {{ Form::checkbox('featured', 1, $product->featured ?? 0)  }}
                            </div>
                        </div>
                    </div>

                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Product Image</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body text-center">
                            @if(isset($product->image))
                                <img id="image_preview" src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : Storage::disk(config('storage.disk'))->url($product->image) }}" />
                            @else
                                <img id="image_preview" />
                            @endif
                            {{ Form::file('image', array('id' => 'image')) }}
                        </div>
                    </div>

                    <!-- ### Product Price ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> Product Price</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group col-md-6">
                                {{ Form::label('regular_price', 'Regular Price') }}
                                {{ Form::text('regular_price', old('regular_price', $product->regular_price ?? ''), array('class' => 'form-control', 'placeholder' => 'Regular Price')) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('sale_price', 'Sale Price') }}
                                {{ Form::text('sale_price', old('sale_price', $product->sale_price ?? ''), array('class' => 'form-control', 'placeholder' => 'Sale Price')) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('from_date', 'From') }}
                                {{ Form::text('from_date', old('from_date', $product->from_date ?? ''), array('class' => 'form-control', 'id' => 'from_date', 'placeholder' => 'From', 'readonly' => 'readonly')) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('to_date', 'To') }}
                                {{ Form::text('to_date', old('to_date', $product->to_date ?? ''), array('class' => 'form-control', 'id' => 'to_date', 'placeholder' => 'To', 'readonly' => 'readonly')) }}
                            </div>
                        </div>
                    </div>

                    <!-- ### Product Inventory ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> Product Inventory</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                {{ Form::label('sku', 'SKU') }}
                                {{ Form::text('sku', old('sku', $product->sku ?? ''), array('class' => 'form-control', 'placeholder' => 'SKU')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('stock_status', 'Stock Status') }}
                                {{ Form::select('stock_status', $stocks, old('stock_status', $product->stock_status ?? ''), array('class' => 'form-control select2')) }}
                            </div>
                        </div>
                    </div>

                    <!-- ### Product Shipping ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> Product Shipping</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                {{ Form::label('weight', 'Weight (Kg)') }}
                                {{ Form::text('weight', old('weight', $product->weight ?? ''), array('class' => 'form-control', 'placeholder' => 'Weight')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('width', 'Width') }}
                                {{ Form::text('width', old('width', $product->width ?? ''), array('class' => 'form-control', 'placeholder' => 'Width')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('height', 'Height') }}
                                {{ Form::text('height', old('height', $product->height ?? ''), array('class' => 'form-control', 'placeholder' => 'Height')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('length', 'Length') }}
                                {{ Form::text('length', old('length', $product->length ?? ''), array('class' => 'form-control', 'placeholder' => 'Length')) }}
                            </div>
                        </div>
                    </div>

                    <!-- ### Product Gallery ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> Product Gallery</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body gallery-body">
                            <div class="product_images_container">
                                <input type="hidden" name="gallery" id="gallery" value="{{ $product->gallery ?? '' }}">
                                <ul class="product_images ui-sortable">
                                    @if(isset($product->galleries) > 0)
                                        @foreach ($product->galleries as $gallery)
                                            <li class="col-lg-3 col-sm-4 col-xs-6 image">
                                                <span class="gallery-trash" onclick="deleteGallery(this)">&times;</span>
                                                <img src="{{ $gallery }}">
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="form-group" style="clear: both; text-align: center; padding-top: 5px">
                                <a href="#" data-choose="Add images to product gallery" id="add_gallery">Add product gallery images</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        {{ Form::close() }}
    </div>

    {{-- Tinymce content image upload --}}
    @include('Admin.Partial.upload', ['slug' => 'products'])

    {{-- Delete content --}}
    @include('Admin.Product.delete')

    {{-- Upload image gallery --}}
    @include('Admin.Product.gallery')

@stop

@section('javascript')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/tinymce_config.js') }}"></script>
    <script src="{{ asset('assets/js/preview.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                selector: 'textarea.richTextBox[name="description"]',
            };
            tinymce.init(getConfig(additionalConfig));

            $( "#from_date" ).datepicker({
                dateFormat: "yy-mm-dd",
            }).on( "change", function() {
                $("#to_date").datepicker( "option", "minDate", getDate( this ) );
            });

            $("#to_date").datepicker({
                dateFormat: "yy-mm-dd",
            }).on( "change", function() {
                $("#from_date").datepicker( "option", "maxDate", getDate( this ) );
            });

            function getDate( element ) {
                let date;
                try {
                    date = $.datepicker.parseDate( "yy-mm-dd", element.value );
                } catch( error ) {
                    date = null;
                }

                return date;
            }
        });
    </script>
@stop
