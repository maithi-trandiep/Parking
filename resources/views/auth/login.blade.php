<!DOCTYPE html>
<html lang="en">
@include('includes.header')
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>PARKING</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Veuillez remplir vos identifiants pour se connecter</p>
        @if(session()->has('message'))
            <p class="alert alert-info">
                {{ session()->get('message') }}
            </p>
        @endif

        <form action="{{ route('login') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="input-group mb-3">
                <input id="email" type="email" class="form-control" name="email" require autofocus placeholder="Email" value="{{ old('email', null) }}">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
                @if($errors->has('email'))
                    <p class="help-block">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control" name="password" placeholder="Mot de passe">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
                @if($errors->has('password'))
                    <p class="help-block">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>
            <div class="row">
            <!-- /.col -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Valider</button>
            </div>
            <!-- /.col -->
            </div>
        </form>
        
        <p class="mb-1">
            <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
        </p>
        <p class="mb-0">
            <a href="{{ route('register') }}" class="text-center">S'inscrire</a>
        </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
@include('includes.jQuery')
</body>
</html>
