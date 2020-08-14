@extends('Layout.layout')

@section('title', (isset($id) ? 'Edit' : 'Add') . ' Role')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-lock"></i>
        {{ (isset($id) ? 'Edit' : 'Add') . ' Role' }}
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
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', old('name', $role->name ?? ''), array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('display_name', 'Display Name') }}
                                {{ Form::text('display_name', old('display_name', $role->display_name ?? ''), array('class' => 'form-control', 'id' => 'display_name', 'placeholder' => 'Display Name')) }}
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
