@extends('layouts.guest')

@section('content')
@vite('resources/css/style.css')

{{-- Login Form --}}
<div class="login-page">
    <div class="login-card">
        <h1 class="login-title">Login</h1>
        <form method="POST" action="/login">
            @csrf
            
            <input type="hidden" name="card_token" id="card_token">
            {{-- User Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">
                    Email Address
                </label>
                <input
                    id="email"
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
                    placeholder="Enter your email"
                >
                {{--  Email Error--}}
                @error('email')
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            {{-- User Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">
                    Password
                </label>
                <input
                    id="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                >
                @error('password')
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            {{-- Remember Me --}}
            <div class="remember-row">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>
            </div>
            {{-- Login Button --}}
            <button type="submit" class="login-btn">
                Login
            </button>
        </form>
    </div>
</div>
@endsection