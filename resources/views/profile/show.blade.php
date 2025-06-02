@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Profile</h1>

    <div class="card">
        <div class="card-header">
            User Information
        </div>

        <div class="card-body">
            <ul>
                <li><strong>ID:</strong> {{ $user->id }}</li>
                <li><strong>First Name:</strong> {{ $user->first_name }}</li>
                <li><strong>Last Name:</strong> {{ $user->last_name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Password:</strong> ********</li>  <!-- Don't show the actual password -->
                <li><strong>Gender:</strong> {{ $user->gender }}</li>
                <li><strong>Date of Birth:</strong> {{ $user->dob }}</li>
                <li><strong>Mobile:</strong> {{ $user->mobile }}</li>
                <li><strong>Marital Status:</strong> {{ $user->marital_status }}</li>
                <li><strong>Joined At:</strong> {{ $user->created_at->format('d-m-Y') }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
