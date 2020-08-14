@extends('Layout.layout')

@section('title', 'Mail Settings')

@section('css')
    <link href="{{ asset('assets/css/setting.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
        .label-heading {
            font-weight: 500;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-settings"></i> Mail Settings
    </h1>
@stop

@section('content')
    @include('Admin/Partial/alerts')
    <div class="container-fluid">
        <div class="alert alert-info">
            <strong>How To Use::</strong>
            You can get the value of each setting anywhere on your site by calling
            <code>setting('mail.key')</code>
        </div>
    </div>

    <div class="page-content settings container-fluid">
        <div class="row">
            <div class="col-md-4">
                <form action="{{ route('mail.update') }}" method="POST" enctype="multipart/form-data">
                    {{ method_field("PUT") }}
                    {{ csrf_field() }}
                    <div class="panel">
                        <div class="page-content settings container-fluid">
                            <div class="panel-body">
                                <div class="form-group">
                                    <h3 class="panel-title">
                                        {{ Form::label('server', 'Mail Server', array('class' => 'label-heading')) }} <code>setting('mail.server')</code>
                                    </h3>
                                    {{ Form::text('server', old('server', $mail['server'] ?? ''), array('class' => 'form-control', 'placeholder' => 'Mail Server')) }}
                                </div>
                                <div class="form-group">
                                    <h3 class="panel-title">
                                        {{ Form::label('port', 'Port', array('class' => 'label-heading')) }} <code>setting('mail.port')</code>
                                    </h3>
                                    {{ Form::text('port', old('port', $mail['port'] ?? ''), array('class' => 'form-control', 'placeholder' => 'Port')) }}
                                </div>
                                <div class="form-group">
                                    <h3 class="panel-title">
                                        {{ Form::label('login', 'Login Name', array('class' => 'label-heading')) }} <code>setting('mail.login')</code>
                                    </h3>
                                    {{ Form::text('login', old('login', $mail['login'] ?? ''), array('class' => 'form-control', 'placeholder' => 'Login Name')) }}
                                </div>
                                <div class="form-group">
                                    <h3 class="panel-title">
                                        {{ Form::label('password', 'Password', array('class' => 'label-heading')) }} <code>setting('mail.password')</code>
                                    </h3>
                                    {{ Form::text('password', old('login', $mail['password'] ?? ''), array('class' => 'form-control', 'placeholder' => 'Password')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::button( 'Save', ['type' => 'submit', 'class' => 'btn btn-primary pull-right']) }}
                </form>
            </div>
            <div class="col-md-8">
                <form action="{{ route('mail.send') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="panel">
                        <div class="page-content settings container-fluid">
                            <div class="panel-body">
                                <h3 class="panel-title">
                                    {{ Form::label('quick-email', 'Quick Email', array('class' => 'label-heading')) }}
                                </h3>
                                <div class="form-group">
                                    {{ Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'Email to:')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::text('subject', '', array('class' => 'form-control', 'placeholder' => 'Subject')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::textarea('message', '', array('class' => 'form-control richTextBox')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::button( 'Send', ['type' => 'submit', 'class' => 'btn btn-primary pull-right']) }}
                </form>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/quickemail_config.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Tiny Mce Setting
            let additionalConfig = {
                selector: 'textarea.richTextBox[name="message"]',
            };
            tinymce.init(getConfig(additionalConfig));
        });
    </script>
@stop
