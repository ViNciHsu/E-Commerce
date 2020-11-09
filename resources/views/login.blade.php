@extends('master')
@section('content')
<div class="container custom-login">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <strong>Warning!</strong>&nbsp;{{ $error }}
                    @endforeach
                </div>
            @endif
            <form action="login" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email address">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>
                <br>
                <button type="submit" class="btn btn-info btn-block">Login</button>
            </form>

            <div class="social-auth-links text-center mb-3">
                <br>

{{--                <p>- OR -</p>--}}
{{--                <a href="/google-sign-in" class="btn btn-block btn-danger">--}}
{{--                    <i class="fa fa-google mr-2"></i> Login With Google--}}
{{--                </a>--}}
{{--                <a href="/facebook/link" class="btn btn-block btn-primary"> 測試 fb登入 </a>--}}

{{--                <a href="{{ URL::asset('/facebook-sign-in') }}" class="btn btn-block btn-primary">--}}
{{--                    <i class="fa fa-facebook mr-2"></i> Sign in using Facebook--}}
{{--                </a>--}}
{{--                    <a href="/user/auth/github-sign-in" class="btn btn-block" style="background-color: #111111;color: #ffffff">--}}
{{--                        <i class="fa fa-github mr-2"></i> Sign in using Github--}}
{{--                    </a>--}}
            </div>
        </div>
    </div>
</div>
@endsection
