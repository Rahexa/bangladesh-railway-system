<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page | Bangladesh Railway</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: url('image/metro1.jpg') no-repeat center center fixed;
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
            background: linear-gradient(to bottom, rgba(0, 91, 92, 0.85), transparent);
        }
        .header h1 {
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .login-box {
            background: rgba(114, 133, 135, 0.3);
            border-radius: 16px;
            padding: 30px;
            width: 340px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), inset 0 0 12px rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(0, 91, 92, 0.5);
            position: relative;
            overflow: hidden;
            text-align: center;
            backdrop-filter: blur(5px);
        }
        .login-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 91, 92, 0.3), transparent 70%);
            animation: glow 10s infinite ease-in-out;
            z-index: -1;
        }
        @keyframes glow {
            0%, 100% { transform: scale(1); opacity: 0.4; }
            50% { transform: scale(1.15); opacity: 0.7; }
        }
        .login-logo {
            width: 85px;
            height: auto;
            margin-bottom: 25px;
            filter: drop-shadow(0 0 8px rgba(255, 51, 51, 0.6));
            transition: transform 0.3s ease;
        }
        .login-logo:hover {
            transform: scale(1.1);
        }
        .login-text {
            margin-bottom: 20px;
        }
        .login-text h1 {
            font-size: 26px;
            font-weight: 900;
            color: #D6EAF8;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 0 0 12px rgba(214, 234, 248, 0.8);
        }
        .login-text p {
            font-size: 13px;
            color: #d1d1d1;
            font-weight: 300;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        .login-box input[type="email"],
        .login-box input[type="password"],
        .login-box input[type="text"] {
            height: 40px;
            padding: 10px 12px 10px 40px;
            border: none;
            border-radius: 10px;
            width: 100%;
            font-size: 14px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .login-box input::placeholder {
            color: transparent;
        }
        .login-box input:focus {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 15px rgba(0, 91, 92, 0.6);
            outline: none;
        }
        .form-group label {
            position: absolute;
            left: 40px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0a0a0;
            font-size: 14px;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            top: 0;
            font-size: 12px;
            color: #005b5c;
            background: transparent;
            padding: 0 5px;
        }
        .form-group::before {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0a0a0;
            transition: color 0.3s ease;
            z-index: 1;
        }
        .form-group:first-child::before {
            content: "\f0e0";
        }
        .form-group:nth-child(2)::before {
            content: "\f023";
        }
        .login-box input:focus ~ ::before {
            color: #005b5c;
        }
        .login-box button.btn {
            width: 100%;
            height: 40px;
            background: linear-gradient(135deg, #005b5c, #003d3e);
            border: none;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .login-box button.btn:hover {
            background: linear-gradient(135deg, #003d3e, #ff3333);
            box-shadow: 0 0 20px rgba(0, 91, 92, 0.7);
            transform: translateY(-2px);
        }
        .login-box button.btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }
        .login-box button.btn:active::after {
            width: 200px;
            height: 200px;
            opacity: 0;
        }
        #togglePassword {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #a0a0a0;
            transition: color 0.3s ease;
            z-index: 1;
        }
        #togglePassword:hover {
            color: #ff3333;
        }
        .login-social {
            text-align: center;
            margin-top: 20px;
        }
        .login-social h3 {
            font-size: 12px;
            color: #d1d1d1;
            margin-bottom: 12px;
            font-weight: 300;
        }
        .login-social-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .login-social-buttons img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
            filter: grayscale(30%);
        }
        .login-social-buttons img:hover {
            transform: scale(1.15) rotate(5deg);
            box-shadow: 0 0 12px rgba(0, 91, 92, 0.7);
            filter: grayscale(0%);
        }
        .text-center {
            margin-top: 15px;
            text-align: center;
        }
        .text-center a {
            color: #ff3333;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .text-center a:hover {
            color: #cc2929;
            text-decoration: underline;
        }
        .remember-text {
            color: #d1d1d1;
            font-weight: 300;
        }
        .error-message {
            background: rgba(255, 51, 51, 0.2);
            color: #ff3333;
            font-size: 12px;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: left;
            border: 1px solid rgba(255, 51, 51, 0.3);
        }
        .forgot-password-link {
            display: block;
            margin-top: 10px;
            color: #ff3333;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .forgot-password-link:hover {
            color: #cc2929;
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .login-box {
                width: 90%;
                padding: 25px;
            }
            .header {
                padding: 0 20px;
                height: 70px;
            }
            .header h1 {
                font-size: 26px;
            }
            .login-logo {
                width: 70px;
            }
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Bangladesh Railway</h1>
</div>
<div class="login-box">
    <div class="login-text">
        <h1>SIGN IN <i class="fa fa-lock" style="margin-left: 8px;"></i></h1>
        <p>Enter your credentials to log in</p>
    </div>
    <form role="form" action="{{ route('login') }}" method="post" class="login-form">
        @csrf
        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif
        @if ($errors->has('email') || $errors->has('password'))
            <div class="error-message">
                @error('email') {{ $message }} @enderror
                @error('password') {{ $message }} @enderror
            </div>
        @endif
        <div class="form-group">
            <input type="email" name="email" id="l-form-email" required placeholder="Email" value="{{ old('email') }}">
            <label for="l-form-email">Email</label>
        </div>
        <div class="form-group position-relative">
            <input type="password" name="password" id="l-form-password" required placeholder="Password">
            <label for="l-form-password">Password</label>
            <i class="fas fa-eye" id="togglePassword" aria-label="Toggle password visibility"></i>
        </div>
        <button type="submit" class="btn">Sign In</button>
        <div class="text-center">
            <label class="checkbox-inline">
                <input type="checkbox" name="remember" style="accent-color: #ff3333;" aria-label="Remember me"> 
                <span class="remember-text">Remember me</span>
            </label>
            <p style="margin-top: 10px;">Don’t have an account? <a href="{{ route('register') }}">Sign up</a></p>
            <a href="{{ route('forgot-password') }}" class="forgot-password-link">Forgot Password?</a>
        </div>
    </form>
    <div class="login-social">
        <h3>Or login with</h3>
        <div class="login-social-buttons">
            <a href="https://google.com"><img src="image/google.png" alt="Google"></a>
            <a href="https://twitter.com"><img src="image/twt.png" alt="Twitter"></a>
            <a href="https://facebook.com"><img src="image/fb.png" alt="Facebook"></a>
        </div>
    </div>
</div>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#l-form-password');
    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>