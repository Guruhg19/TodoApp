@extends('layout.app')

@section('title','Register')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h1>Register</h1>
            @include('layout.notif')
            <form action="" method="post">
            @csrf
                <div class="mb-2">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{ old('email') }}">
                </div>
                <div class="mb-2">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                </div>
                <h3>Password</h3>
                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-2">
                    <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password-confirm" id="password-confirm">
                </div>
                <div class="d-inline">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('forgotpassword') }}">Lupa Password</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection