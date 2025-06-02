<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign Up | Bangladesh Railway</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: url('/image/metro1.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            height: 80px;
            padding: 0 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            background: linear-gradient(to bottom, rgba(0, 102, 104, 0.9), transparent);
        }
        .header h1 {
            font-size: 34px;
            font-weight: 900;
            color: #fff;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        .signup-box {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 20px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5), inset 0 0 15px rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            text-align: center;
            backdrop-filter: blur(12px);
            transition: transform 0.3s ease;
        }
        .signup-box:hover {
            transform: translateY(-5px);
        }
        .signup-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 102, 104, 0.4), transparent 70%);
            animation: glow 12s infinite ease-in-out;
            z-index: -1;
        }
        @keyframes glow {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.6; }
        }
        .signup-logo {
            width: 75px;
            margin-bottom: 12px;
            filter: drop-shadow(0 0 10px rgba(255, 77, 77, 0.7));
            transition: transform 0.4s ease;
        }
        .signup-logo:hover {
            transform: rotate(10deg) scale(1.15);
        }
        .signup-text {
            margin-bottom: 12px;
        }
        .signup-text h1 {
            font-size: 22px;
            font-weight: 900;
            color: #E6F3FF;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 0 0 15px rgba(230, 243, 255, 0.9);
        }
        .signup-text p {
            font-size: 12px;
            color: #d8d8d8;
            font-weight: 400;
            opacity: 0.9;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            align-items: start;
        }
        .form-group {
            margin-bottom: 10px;
            position: relative;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        .signup-box input[type="text"],
        .signup-box input[type="email"],
        .signup-box input[type="password"],
        .signup-box input[type="date"],
        .signup-box input[type="tel"],
        .signup-box select {
            height: 38px;
            padding: 8px 12px 8px 34px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 12px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
        .signup-box input::placeholder {
            color: transparent;
        }
        .signup-box select:invalid {
            color: rgba(255, 255, 255, 0.7);
        }
        .signup-box input:focus,
        .signup-box select:focus {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 15px rgba(0, 102, 104, 0.7), inset 0 2px 4px rgba(0, 0, 0, 0.1);
            outline: none;
            transform: scale(1.02);
        }
        .form-group.select-wrapper {
            position: relative;
        }
        .form-group.select-wrapper::after {
            content: '\f078';
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0b0b0;
            font-size: 12px;
            pointer-events: none;
            transition: color 0.3s ease;
        }
        .form-group.select-wrapper select:focus ~ ::after {
            color: #00ccff;
        }
        .signup-box select {
            cursor: pointer;
        }
        .signup-box select option {
            background: #1a2a44;
            color: #fff;
            font-size: 12px;
        }
        .form-group label {
            position: absolute;
            left: 34px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0b0b0;
            font-size: 12px;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label,
        .form-group select:focus + label,
        .form-group select:not(:invalid) + label {
            top: -7px;
            left: 12px;
            font-size: 9px;
            color: #00ccff;
            background: rgba(255, 255, 255, 0.1);
            padding: 1px 4px;
            border-radius: 4px;
            box-shadow: 0 0 6px rgba(0, 204, 255, 0.5);
        }
        .form-group::before {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0b0b0;
            font-size: 12px;
            transition: all 0.3s ease;
            z-index: 1;
        }
        .form-group.first-name::before { content: "\f007"; }
        .form-group.last-name::before { content: "\f007"; }
        .form-group.email::before { content: "\f0e0"; }
        .form-group.password::before { content: "\f023"; }
        .form-group.confirm-password::before { content: "\f023"; }
        .form-group.gender::before { content: "\f228"; }
        .form-group.dob::before { content: "\f073"; }
        .form-group.mobile::before { content: "\f095"; }
        .form-group.marital-status::before { content: "\f2e0"; }
        .signup-box input:focus ~ ::before,
        .signup-box select:focus ~ ::before {
            color: #00ccff;
            transform: translateY(-50%) scale(1.1);
        }
        .signup-box button.btn {
            width: 100%;
            height: 38px;
            background: linear-gradient(135deg, #00ccff, #0066cc);
            border: none;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 204, 255, 0.5);
            margin-top: 5px;
        }
        .signup-box button.btn:hover {
            background: linear-gradient(135deg, #0066cc, #ff4d4d);
            box-shadow: 0 8px 25px rgba(0, 204, 255, 0.7);
            transform: translateY(-3px);
        }
        .signup-box button.btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.5s ease, height 0.5s ease;
        }
        .signup-box button.btn:active::after {
            width: 300px;
            height: 300px;
            opacity: 0;
        }
        .signup-box button.btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%);
            opacity: 0;
            animation: pulse 3s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0; }
            50% { opacity: 0.3; }
        }
        .signup-social {
            margin-top: 12px;
        }
        .signup-social h3 {
            font-size: 11px;
            color: #d8d8d8;
            margin-bottom: 10px;
            font-weight: 400;
            opacity: 0.9;
        }
        .signup-social-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .signup-social-buttons img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            filter: grayscale(20%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }
        .signup-social-buttons img:hover {
            transform: scale(1.2) rotate(8deg);
            box-shadow: 0 5px 15px rgba(0, 204, 255, 0.7);
            filter: grayscale(0%);
            border-color: #00ccff;
        }
        .text-center {
            margin-top: 12px;
        }
        .text-center a {
            color: #ff4d4d;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .text-center a:hover {
            color: #ff1a1a;
            text-decoration: underline;
            text-shadow: 0 0 5px rgba(255, 26, 26, 0.5);
        }
        .error-message {
            background: rgba(255, 51, 51, 0.2);
            color: #ff3333;
            font-size: 10px;
            padding: 6px 8px;
            border-radius: 6px;
            margin-top: 4px;
            text-align: left;
            border: 1px solid rgba(255, 51, 51, 0.3);
            display: block;
        }
        .success-message {
            background: rgba(51, 255, 51, 0.2);
            color: #33ff33;
            font-size: 10px;
            padding: 6px 8px;
            border-radius: 6px;
            margin-bottom: 10px;
            text-align: center;
            border: 1px solid rgba(51, 255, 51, 0.3);
        }
        .general-error {
            background: rgba(255, 51, 51, 0.2);
            color: #ff3333;
            font-size: 10px;
            padding: 6px 8px;
            border-radius: 6px;
            margin-bottom: 10px;
            text-align: center;
            border: 1px solid rgba(255, 51, 51, 0.3);
        }
        @media (max-width: 768px) {
            .signup-box {
                width: 90%;
                padding: 15px;
                max-width: 360px;
            }
            .header {
                padding: 0 20px;
                height: 70px;
            }
            .header h1 {
                font-size: 28px;
            }
            .signup-logo {
                width: 60px;
            }
            .form-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            .signup-text h1 {
                font-size: 18px;
            }
            .signup-box input,
            .signup-box select {
                height: 36px;
                font-size: 11px;
            }
            .signup-box button.btn {
                height: 36px;
                font-size: 11px;
            }
            .form-group label {
                font-size: 11px;
            }
            .form-group input:focus + label,
            .form-group input:not(:placeholder-shown) + label,
            .form-group select:focus + label,
            .form-group select:not(:invalid) + label {
                font-size: 8px;
                top: -6px;
                padding: 1px 3px;
            }
            .signup-text p {
                font-size: 11px;
            }
            .signup-social h3 {
                font-size: 10px;
            }
            .signup-social-buttons img {
                width: 32px;
                height: 32px;
            }
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Bangladesh Railway</h1>
</div>
<div class="signup-box">
    <div class="signup-text">
        <h1>SIGN UP <i class="fa fa-user-plus" style="margin-left: 8px;"></i></h1>
        <p>Create your account to get started</p>
    </div>
    @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="general-error">{{ session('error') }}</div>
    @endif
    <form action="{{ route('register') }}" method="post" class="signup-form">
        @csrf
        <div class="form-grid">
            <div class="form-group first-name">
                <input type="text" name="first_name" id="first-name" required placeholder="First Name" aria-label="First Name" value="{{ old('first_name') }}">
                <label for="first-name">First Name</label>
                @error('first_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group last-name">
                <input type="text" name="last_name" id="last-name" required placeholder="Last Name" aria-label="Last Name" value="{{ old('last_name') }}">
                <label for="last-name">Last Name</label>
                @error('last_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group email full-width">
                <input type="email" name="email" id="email" required placeholder="Email" aria-label="Email" value="{{ old('email') }}">
                <label for="email">Email</label>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group password">
                <input type="password" name="password" id="password" required placeholder="Password" aria-label="Password">
                <label for="password">Password</label>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group confirm-password">
                <input type="password" name="password_confirmation" id="confirm-password" required placeholder="Confirm Password" aria-label="Confirm Password">
                <label for="confirm-password">Confirm Password</label>
                @error('password_confirmation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group gender select-wrapper">
                <select name="gender" id="gender" required aria-label="Gender">
                    <option value="" disabled selected></option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                <label for="gender">Gender</label>
                @error('gender')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group dob">
                <input type="date" name="dob" id="dob" required placeholder="Date of Birth" aria-label="Date of Birth" value="{{ old('dob') }}">
                <label for="dob">Date of Birth</label>
                @error('dob')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mobile">
                <input type="tel" name="mobile" id="mobile" required placeholder="Mobile Number" aria-label="Mobile Number" value="{{ old('mobile') }}">
                <label for="mobile">Mobile Number</label>
                @error('mobile')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group marital-status select-wrapper">
                <select name="marital_status" id="marital-status" required aria-label="Marital Status">
                    <option value="" disabled selected></option>
                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                    <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                    <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                </select>
                <label for="marital-status">Marital Status</label>
                @error('marital_status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn">Sign Up</button>
        <div class="text-center">
            <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
        </div>
    </form>
    <div class="signup-social">
        <h3>Or sign up with</h3>
        <div class="signup-social-buttons">
            <a href="https://google.com"><img src="/image/google.png" alt="Google" aria-label="Sign up with Google"></a>
            <a href="https://twitter.com"><img src="/image/twt.png" alt="Twitter" aria-label="Sign up with Twitter"></a>
            <a href="https://facebook.com"><img src="/image/fb.png" alt="Facebook" aria-label="Sign up with Facebook"></a>
        </div>
    </div>
</div>
<script>
    const inputs = document.querySelectorAll('.signup-box input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => input.parentElement.classList.add('focused'));
        input.addEventListener('blur', () => input.parentElement.classList.remove('focused'));
    });
    const selects = document.querySelectorAll('.signup-box select');
    selects.forEach(select => {
        select.addEventListener('change', () => {
            if (select.value) select.parentElement.classList.add('focused');
            else select.parentElement.classList.remove('focused');
        });
    });
</script>
</body>
</html>