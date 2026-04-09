@extends('admin.admin')

@section('content')
    <h1>Dashboard Admin</h1>
    <br>
    <div class="cards">
        <div class="card">
            <h3>Total utilisateurs</h3>
            <p>{{ $userCount }}</p>
        </div>
        <div class="card">
            <h3>Admins</h3>
            <p>{{ $adminCount }}</p>
        </div>
    </div>
@endsection