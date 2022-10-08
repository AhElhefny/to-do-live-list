@extends('app', ['required' => 'no'])
@section('content')
    <div class="row w-100 m-0">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
                <div class="card-body px-5 py-5">
                    <h3 class="card-title text-left mb-3">Login For Admin</h3>
                    <form method="post" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label>Username or email *</label>
                            <input type="text" class="form-control p_input" name="email" value="{{old('email')}}">
                        </div>
                        @error('email')
                            <span class="text text-danger">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label>Password *</label>
                            <input type="password" class="form-control p_input" name="password" autocomplete="false">
                        </div>
                        @error('password')
                            <span class="text text-danger">{{ $message }}</span>
                        @enderror
                        <div class="form-group d-flex align-items-center justify-content-between">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="Remember" value="true" class="form-check-input"> Remember
                                    me </label>
                            </div>
                            <a href="#" class="forgot-pass">Forgot password</a>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                        </div>
{{--                        <div class="d-flex">--}}
{{--                            <button class="btn btn-facebook mr-2 col">--}}
{{--                                <i class="mdi mdi-facebook"></i> Facebook </button>--}}
{{--                            <button class="btn btn-google col">--}}
{{--                                <i class="mdi mdi-google-plus"></i> Google plus </button>--}}
{{--                        </div>--}}
{{--                        <p class="sign-up">Don't have an Account?<a href="#"> Sign Up</a></p>--}}
                    </form>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
