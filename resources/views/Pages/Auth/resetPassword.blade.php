@extends('layout.master')
@section('title', 'Reset Password')

@section('content')
    <div class="container mt-5">
        <h1>Reset Password</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('auth.reset-password') }}" method="POST" class="row g-3">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="col-12">
                <label class="form-label" for="email">Email Address</label>
                <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" placeholder="Enter email" value="{{ request()->query('email') }}" required readonly>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label" for="password">New Password</label>
                <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Enter new password" required>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm new password" required>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary w-100" type="submit">Reset Password</button>
            </div>
        </form>
    </div>
@endsection
