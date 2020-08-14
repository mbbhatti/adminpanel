@extends('Layout.layout')

@section('title', (isset($id) ? 'Edit' : 'Add') . ' Category')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-categories"></i>
        {{ (isset($id) ? 'Edit' : 'Add') . ' Category' }}
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
                <div class="col-md-12">
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
                                {{ Form::label('parent', 'Parent') }}
                                {{ Form::select('parent', $categories->prepend('None', ''), old('parent', $category->parent_id ?? ''), array('class' => 'form-control select2', 'id' => 'parent')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('order', 'Order') }}
                                {{ Form::text('order', old('order', $category->order ?? 1), array('class' => 'form-control', 'id' => 'order')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', old('name', $category->name ?? ''), array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('slug', 'Slug') }}
                                {{ Form::text('slug', old('slug', $category->slug ?? ''), array('class' => 'form-control', 'id' => 'slug', 'placeholder' => 'Slug')) }}
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
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#name').on('keyup change', function (e) {
                let str = $(this).val();
                let trimmed = $.trim(str);
                let $slug = trimmed.replace(/[^a-z0-9-]/gi, '-') . replace(/-+/g, '-') . replace(/^-|-$/g, '');
                $('#slug').val($slug.toLowerCase());
            });
        });
    </script>
@stop
