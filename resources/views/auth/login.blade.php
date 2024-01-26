<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.header')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b>LTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                <form action="{{ route('login_post') }}" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                            <span type='error' style="color: red">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                        <div class="col-12">
                            <div class="w-100 mt-3">
                                <label for="Register">
                                    <a href="{{ route('register') }}" class="text-primary "> Don't have an account?
                                        Register now </a>
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="w-100 mt-1">
                                <label for="Register">
                                    <a href="{{ route('forgot_password') }}" class="text-primary "> Forgot your password
                                        ?</a>
                                </label>
                            </div>
                        </div>
                    </div>
                    @csrf
                </form>

            </div>
        </div>
    </div>
    <!-- /.login-box -->

    @include('partials.footer')
</body>

</html>
