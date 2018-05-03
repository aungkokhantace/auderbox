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
        <div class="col-md-5 col-md-offset-3 login-left">
            <div class="border">

                <div class="login">
                    Reset Password
                </div>
                <!-- Starting Form -->
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/backend/password/email') }}">
                    {{ csrf_field() }}
                @if (session('status'))
                    <p class="alert alert-danger">
                        {{ session('status') }}
                    </p>
                @endif
                @if ($errors->has())
                    <p class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </p>
                @endif

                <div class="user">
                    <div class="col-md-2">
                        <label class="reset_pwd_lbl">Email</label>
                    </div>
                    <div class="col-md-9">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">


                    </div>
                </div>
                <div class="col-md-11 col-md-offset-1 gap">
                    <!-- -->
                </div>
                <!-- Inserting Password -->
                <div class="user">
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-lg fill_color reset_btn">
                            <span class="glyphicon glyphicon-envelope"></span>    Send Password Reset Link
                        </button>
                    </div>
                </div>

                    <div class="col-md-11 col-md-offset-1 gap">
                        <!-- -->
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