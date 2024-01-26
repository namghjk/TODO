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
                <p class="login-box-msg">Reset your password</p>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('post_reset_password') }}" method="post">
                    @csrf
                    <input type="text" hidden="true" value="{{ $token }}" name="token" />
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('email'))
                        <span type='error' style="color: red">{{ $errors->first('email') }}</span>
                    @endif
                    <div class="input-group mb-3">
                        <input type="text" name="password" class="form-control" placeholder="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                        @if ($errors->first('password') == 'The password format is invalid.')
                            @if (!preg_match('/[a-z]/', old('password')) || !preg_match('/[A-Z]/', old('password')))
                                <div class="error-message">
                                    <span type='error' style="color: red">Password must contain at least one
                                        lowercase, one uppercase character, and
                                        one special character.</span>
                                </div>
                            @endif
                        @else
                            <div class="error-message">
                                <span type='error' style="color: red">{{ $errors->first('password') }}</span>
                            </div>
                        @endif
                    @endif
                    <div class="input-group mb-3">
                        <input type="text" name="confirmPassword" class="form-control"
                            placeholder="confirm password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Reset</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <!-- /.login-box -->

    @include('partials.footer')
</body>

</html>
