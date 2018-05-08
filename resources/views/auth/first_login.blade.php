<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
    <link rel="stylesheet" type="text/css" href="/assets/new_design/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/new_design/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/assets/new_design/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="/assets/new_design/bootstrap/font-awesome/css/font-awesome.css" />

</head>
<body class="login-page">
    <section class="login">
        <div class="container">
            <div class="row text-center">
                <h2 class="login-ttl" style="color: #f37023";><b>AcePlus</b> Management System</h2>
            </div>
            <div class="row">
                <div class="first-login-form">
                    <h3> First Log In</h3>
                    <div class="login-inr">
                         {!! Form::open(array('url' => 'backend/first_login'))!!}
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if ($errors->has())
                            <p class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </p>
                        @endif
                            <div class="form-group clearfix">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <input type="text" name="user_name" id="username" value="{{ Request::old('user_name') }}" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group pwd clearfix">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <input type="password" name="password" id="pw" class="form-control" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-first-login" name="login">LOG IN</button>
                            <!-- <a class="btn btn-link" href="{{ url('/backend/password/reset') }}" style="color: #f37023";>Forgot Your Password?</a> -->
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <img src="/assets/new_design/images/login/aceplus_logo.png" alt="AcePlus Logo" class="aceplus-logo">
            </div>
        </div>
    </section>
</body>
</html>
