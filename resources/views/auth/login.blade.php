@extends('layouts.auth-master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-5  pt-5">
                <form method="post" action="{{ route('login.perform') }}">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <h1 class="h3 mb-3 fw-normal">Login</h1>

                    @include('layouts.partials.messages')

                    <div class="form-group form-floating mb-3">
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
                        @if ($errors->has('username'))
                            <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                        @endif
                    </div>

                    <div class="form-group form-floating mb-3">
                        <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                        @if ($errors->has('password'))
                            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

                    @include('auth.partials.copy')
                </form>
            </div>
        </div>
    </div>
@endsection
