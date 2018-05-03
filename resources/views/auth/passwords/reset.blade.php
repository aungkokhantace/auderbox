<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/login.css" rel="stylesheet">


</head>
<body>
<div class="container">
    <div class="row middle">
        <div class="col-md-5 col-md-offset-3 login-left">
            <p id="logo"><strong>AcePlus</strong> Management System</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3 password_reset_left">
            <div class="password_reset_border">

                <div class="login">
                    Reset Password
                </div>
                <!-- Starting Form -->
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/backend/password/reset') }}">
                    {{ csrf_field() }}
                    @if ($errors->has())
                        <p class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </p>
                    @endif

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="user">
                        <div class="col-md-4">
                            <label for="email" class="reset_pwd_lbl">E-Mail Address</label>
                        </div>
                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}">
                        </div>
                    </div>
                    <br/>

                    <div class="user">
                        <div class="col-md-4">
                            <label for="password" class="reset_pwd_lbl">Password</label>
                        </div>
                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control" name="password">

                        </div>
                    </div>
                    <br/>

                    <div class="user">
                        <div class="col-md-4">
                            <label for="password-confirm" class="reset_pwd_lbl">Confirm Password</label>
                        </div>
                        <div class="col-md-8">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    <br/>

                    <div class="user">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-lg fill_color reset_btn">
                                <span class="glyphicon glyphicon-refresh"></span> Reset Password
                            </button>
                        </div>
                    </div>


                    {!! Form::close() !!}
                            <!-- Ending Form -->
            </div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-5 col-md-offset-3 login-center">
            <img src="/images/aceplus_logo.png" class="pull-left height-full m-r-5">
        </div>
    </div>
</div>
</body>
</html>
