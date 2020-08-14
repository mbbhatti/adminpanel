@extends('Layout.layout')

@section('title', (isset($id) ? 'Edit' : 'Add') . ' Menu Item')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list-add"></i>
        {{ (isset($id) ? 'Edit' : 'Add') . ' Menu Item' }}
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
                                {{ Form::label('title', 'Title') }}
                                {{ Form::text('title', old('title', $menu->title ?? ''), array('class' => 'form-control', 'placeholder' => 'Title')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('url_type', 'URL Type') }}
                                {{ Form::select('url_type', $types, old('url_type', $menu->url_type ?? 'URL'), array('class' => 'form-control select2', 'id' => 't_link')) }}
                            </div>
                            <div class="form-group" id="t_url" style="display: {{(empty($id) || isset($menu->url)) ? 'block': 'none'}}">
                                {{ Form::label('url', 'URL') }}
                                {{ Form::text('url', old('url', $menu->url ?? ''), array('class' => 'form-control', 'placeholder' => 'URL')) }}
                            </div>
                            <div class="form-group" id="t_route" style="display: {{isset($menu->route) ? 'block': 'none'}}">
                                {{ Form::label('route', 'Route') }}
                                {{ Form::text('route', old('route', $menu->route ?? ''), array('class' => 'form-control', 'placeholder' => 'Route')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('icon', 'Title Icon') }}
                                {{ Form::text('icon', old('icon', $menu->icon ?? ''), array('class' => 'form-control')) }}
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
            $('#t_link').on('change', function (e) {
                if ($(this).val() == 'Route') {
                    $('#t_url').hide();
                    $('#t_route').show();
                } else {
                    $('#t_route').hide();
                    $('#t_url').show();
                }
            });
        });
    </script>
@stop
