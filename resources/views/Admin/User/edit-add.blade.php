@extends('Layout.layout')

@section('title', (isset($id) ? 'Edit' : 'Add') . ' User')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-person"></i>
        {{ (isset($id) ? 'Edit' : 'Add') . ' User' }}
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
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', old('name', $user->name ?? ''), array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('email', 'Email') }}
                                {{ Form::email('email', old('email', $user->email ?? ''), array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('password', 'Password') }}
                                @if (isset($id))
                                    <br>
                                    <small>Leave empty to keep the same</small>
                                @endif
                                {{ Form::password('password', array('class' => 'form-control', 'id' => 'password', 'autocomplete' => 'new-password')) }}
                            </div>
                            @if (Auth::user()->id != $id)
                                <div class="form-group">
                                    {{ Form::label('default_role', 'Default Role') }}
                                    {{ Form::select('role_id[]', $roles, $userRoles, array('class' => 'form-control select2', 'id' => 'role_id', 'multiple'=>'multiple')) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                <img id="image_preview" src="{{ isset($user->avatar) ? Storage::disk(config('storage.disk'))->url($user->avatar) : Storage::disk(config('storage.disk'))->url('users/default.png') }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                {{ Form::file('avatar', array('id' => 'avatar')) }}
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
    <script src="{{ asset('assets/js/preview.js') }}"></script>
@stop
