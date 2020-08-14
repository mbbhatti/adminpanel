@extends('Layout/auth-layout')

@section('title', 'Login')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="faded-bg animated"></div>
            <div class="hidden-xs col-sm-7 col-md-8">
                <div class="clearfix">
                    <div class="col-sm-12 col-md-10 col-md-offset-2">
                        <div class="logo-title-container">
                            <?php $admin_logo_img = setting('admin.icon_image'); ?>
                            @if($admin_logo_img == '')
                                <img src="{{ asset('assets/images/logo-icon-light.png') }}" class="img-responsive pull-left flip logo hidden-xs animated fadeIn" alt="Logo Icon">
                            @else
                                <img src="{{ Storage::disk(config('storage.disk'))->url($admin_logo_img) }}" class="img-responsive pull-left flip logo hidden-xs animated fadeIn" alt="Logo Icon">
                            @endif
                            <div class="copy animated fadeIn">
                                <h1>Hungry! ORDER Now</h1>
                                <p>LOOKING FOR FOOD, HERE IS EVERYTHING NEW AND DELICIOUS FOR YOU!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">
                <div class="login-container">
                    <p>Sign In Below:</p>
                    {{ Form::open(array('url' => '/admin/login', 'method' => 'POST', 'id' => 'loginForm', 'name' => 'loginForm')) }}
                        {{ csrf_field() }}
                        <div class="form-group form-group-default" id="emailGroup">
                            {{ Form::label('email', 'Email') }}
                            <div class="controls">
                                {{ Form::email('email', old('email'), array('class' => 'form-control', 'placeholder' => 'admin@admin.com', 'required' => 'required')) }}
                            </div>
                        </div>
                        <div class="form-group form-group-default" id="passwordGroup">
                            {{ Form::label('password', 'Password') }}
                            <div class="controls">
                                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'password', 'required' => 'required')) }}
                            </div>
                        </div>
                        <div class="form-group" id="rememberMeGroup">
                            <div class="controls">
                                {{ Form::checkbox('remember', true) }}
                                {{ Form::label('remember', 'Remember me', array('class' => 'remember-me-text')) }}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block login-button">
                            <span class="signingin hidden"><span class="voyager-refresh"></span> Logging in...</span>
                            <span class="signin">Login</span>
                        </button>
                    {{ Form::close() }}
                    <div style="clear:both"></div>
                    @if(!$errors->isEmpty())
                        <div class="alert alert-red">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-red">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        var btn = document.querySelector('button[type="submit"]');
        var form = document.forms[0];
        var email = document.querySelector('[name="email"]');
        var password = document.querySelector('[name="password"]');
        btn.addEventListener('click', function(ev){
            if (form.checkValidity()) {
                btn.querySelector('.signingin').className = 'signingin';
                btn.querySelector('.signin').className = 'signin hidden';
            } else {
                ev.preventDefault();
            }
        });
        email.focus();
        document.getElementById('emailGroup').classList.add("focused");

        // Focus events for email and password fields
        email.addEventListener('focusin', function(e){
            document.getElementById('emailGroup').classList.add("focused");
        });
        email.addEventListener('focusout', function(e){
            document.getElementById('emailGroup').classList.remove("focused");
        });

        password.addEventListener('focusin', function(e){
            document.getElementById('passwordGroup').classList.add("focused");
        });
        password.addEventListener('focusout', function(e){
            document.getElementById('passwordGroup').classList.remove("focused");
        });
    </script>
@stop
