@extends('layout.app')

@section('title','Reset Password')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h1>Reset Password</h1>
            @include('layout.notif')
            <form action="{{ route('resetpassword.post') }}" method="post">
                <input type="hidden" name="token" value="{{ $token }}">
            @csrf
                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-2">
                    <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password-confirm" id="password-confirm">
                </div>
                <div class="d-inline">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection