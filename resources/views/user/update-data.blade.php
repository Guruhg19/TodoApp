@extends('layout.app')

@section('title','Update Data')

@section('nav')
@include('layout.nav')
@endsection

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h1>Update Data</h1>
            @include('layout.notif')
            <form action="{{ route('user.updateData.post') }}" method="post">
            @csrf
                <div class="mb-2">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{ Auth::user()->email }}" disabled>
                </div>
                <div class="mb-2">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : Auth::user()->name }}">
                </div>
                <h3>Password</h3>
                <div class="form-text">
                    Silakan masukkan Password jika akan melakukan pergantian password
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-2">
                    <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password-confirm" id="password-confirm">
                </div>
                <div class="d-inline">
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection