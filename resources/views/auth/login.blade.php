@extends('layouts.auth')

@section('content')
    <form method="POST" accept="{{ route('login.do') }}">
        @csrf
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" name="email" value="{{ old('email') }}" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    </form>
    <p>or</p>
    <a class="w-100 btn btn-lg btn-secondary" href="{{ route('register') }}">Register</a>
@endsection
