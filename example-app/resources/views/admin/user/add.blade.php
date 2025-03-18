@extends('layout.admin')

@section('title', 'Admin User')

@section('header', 'User')

@section('content')
    <div class="container mt-5">
        <h2>Create User</h2>
        <form action="{{ route('admin.user.save') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- Nút Back -->
            <a href="{{ route('admin.user.list') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>

@endsection