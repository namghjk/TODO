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
                <form action="{{ route('post_forget_password') }}" method="post">
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
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Send mail</button>
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
