@extends('layout.app')

@section('title','Reset Password')


@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h1>Reset Password</h1>
            @include('layout.notif')
            <form action="{{ route('forgotpassword.form') }}" method="post">
            @csrf
                <div class="mb-2">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{ old('email') }}">
                </div>
                <div class="d-inline">
                    <button type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection