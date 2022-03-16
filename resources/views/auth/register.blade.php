@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('register.do') }}">
        @csrf
        <h1 class="h3 mb-3 fw-normal">Register</h1>

        <div class="form-floating">
            <input type="text" class="form-control" id="floatingName" name="name" value="{{ old('name') }}" placeholder="name">
            <label for="floatingName">Name</label>
        </div>
        <div class="form-floating">
            <input type="email" class="form-control" id="floatingEmail" name="email" value="{{ old('email') }}" placeholder="name@example.com">
            <label for="floatingEmail">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPasswordConfirmation" name="password_confirmation" placeholder="Password Confirmation">
            <label for="floatingPasswordConfirmation">Password Confirmation</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
    </form>
    <p>or</p>
    <a class="w-100 btn btn-lg btn-secondary" href="{{ route('login') }}">Sign in</a>
@endsection
