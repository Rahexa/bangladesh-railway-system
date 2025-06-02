<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Profile | Bangladesh Railway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .profile-card { max-width: 1000px; width: 100%; border-radius: 20px; box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15); background: #ffffff; overflow: hidden; transition: transform 0.3s ease; }
        .profile-card:hover { transform: translateY(-5px); }
        .sidebar { background: linear-gradient(180deg, #1e3a8a 0%, #3b82f6 100%); color: #ffffff; padding: 40px 20px; display: flex; flex-direction: column; align-items: center; text-align: center; min-height: 100%; }
        .profile-picture { width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 5px solid #ffffff; margin-bottom: 20px; transition: transform 0.4s ease, box-shadow 0.4s ease; }
        .profile-picture:hover { transform: scale(1.1); box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); }
        .profile-name { font-size: 1.8rem; font-weight: 600; margin-bottom: 5px; }
        .profile-email { font-size: 0.95rem; font-weight: 300; opacity: 0.9; }
        .content-area { padding: 30px; }
        .section-title { font-size: 1.5rem; font-weight: 600; color: #1e3a8a; margin-bottom: 20px; }
        .form-floating > .form-control, .form-floating > .form-select { height: calc(3.5rem + 2px); border-radius: 10px; border: 1px solid #d1d5db; transition: border-color 0.3s ease, box-shadow 0.3s ease; }
        .form-floating > .form-control:focus, .form-floating > .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 8px rgba(59, 130, 246, 0.3); }
        .form-floating > label { color: #6b7280; font-size: 0.9rem; padding: 1rem 0.75rem; }
        .form-control[type="file"] { padding: 10px; border-radius: 10px; border: 1px solid #d1d5db; }
        .btn-primary { background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); border: none; border-radius: 10px; padding: 12px 30px; font-size: 1rem; font-weight: 500; transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease; }
        .btn-primary:hover { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4); }
        .alert { border-radius: 10px; font-size: 0.9rem; padding: 15px; margin-bottom: 20px; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
        @media (max-width: 768px) {
            .profile-card { margin: 10px; }
            .sidebar { padding: 20px; }
            .profile-picture { width: 100px; height: 100px; }
            .profile-name { font-size: 1.5rem; }
            .profile-email { font-size: 0.85rem; }
            .content-area { padding: 20px; }
            .section-title { font-size: 1.3rem; }
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="row g-0">
            <div class="col-md-4 sidebar">
                <img class="profile-picture" src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}" alt="User Photo">
                <h2 class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <span class="profile-email">{{ $user->email }}</span>
            </div>
            <div class="col-md-8 content-area">
                <h3 class="section-title">Edit Profile</h3>
                <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{ old('first_name', $user->first_name) }}">
                                <label for="first_name">First Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{ old('last_name', $user->last_name) }}">
                                <label for="last_name">Last Name</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="{{ old('email', $user->email) }}">
                                <label for="email">Email Address</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="password" placeholder="New Password">
                                <label for="password">New Password</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                <label for="password_confirmation">Confirm Password</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="gender" id="gender">
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <label for="gender">Gender</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" name="dob" id="dob" value="{{ old('dob', $user->dob ? $user->dob->format('Y-m-d') : '') }}">
                                <label for="dob">Date of Birth</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" value="{{ old('mobile', $user->mobile) }}">
                                <label for="mobile">Mobile Number</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" name="marital_status" id="marital_status">
                                    <option value="single" {{ old('marital_status', $user->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ old('marital_status', $user->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                    <option value="divorced" {{ old('marital_status', $user->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                </select>
                                <label for="marital_status">Marital Status</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="profile_picture" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" name="profile_picture" id="profile_picture">
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn btn-primary" type="submit">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>