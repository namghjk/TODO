<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b>LTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Register to start your session</p>
                <form action="{{ route('registerPost') }}" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="name@example.com"
                            value="{{ old('email') }}">
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
                        <input type="first_name" name="first_name" class="form-control" placeholder="first_name"
                            value="{{ old('first_name') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="bi bi-file-person"></i>
                            </div>
                        </div>
                        @if ($errors->has('first_name'))
                            <span type='error' style="color: red">{{ $errors->first('first_name') }}</span>
                        @endif
                        <div clas </div>
                            s="input-group mb-3">
                            <input type="last_name" name="last_name" class="form-control" placeholder="last_name"
                                value="{{ old('last_name') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="bi bi-file-person"></i>
                                </div>
                            </div>
                            @if ($errors->has('last_name'))
                                <span type='error' style="color: red">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <input type="address" name="address" class="form-control" placeholder="address"
                                value="{{ old('address') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="bi bi-file-person"></i>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" name="password" class="form-control" placeholder="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
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
                        </div>

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
                            <div class="col-4"></div> <!-- Thêm cột trống để chiếm không gian -->

                            <div class="col-4">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                                </div>
                            </div>
                            <!-- /.col -->

                            <div class="col-4"></div> <!-- Thêm cột trống để chiếm không gian -->
                            <!-- /.col -->
                            <div class="col-12 justify-content-center">
                                <div class="w-100 mt-3  ">
                                    <label for="Login">
                                        <a href="{{ route('login') }}" class="text-primary "> Already have an account?
                                            Back
                                            to login </a>
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

    @include('layouts.footer')
</body>

</html>
