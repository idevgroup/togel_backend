@extends('frontend.template.main')

@section('content')
<div class="container">
    <div class="col-lg-5 mx-auto mt-5">
       {!!Form::open(['url' => route('member.login')])!!}
            <h1 class="h3 mb-3 font-weight-normal mt-5" style="text-align: center"> Sign in</h1>
            <input type="text" id="inputEmail" name="username" class="form-control" placeholder="User/Email" required="" autofocus="">
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">

            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Sign in</button>
            <a href="#" id="forgot_pswd">Forgot password?</a>
            <hr>
            <!-- <p>Don't have an account!</p>  -->
            <button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fas fa-user-plus"></i> Sign up New Account</button>
       {!!Form::close()!!}
    </div>
</div>
@endsection