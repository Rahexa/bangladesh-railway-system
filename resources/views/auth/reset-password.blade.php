<!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta name="csrf-token" content="{{ csrf_token() }}">
       <title>Reset Password | Bangladesh Railway</title>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
       <style>
           * { margin: 0; padding: 0; box-sizing: border-box; }
           body {
               font-family: 'Poppins', sans-serif;
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
               background: linear-gradient(to bottom, rgba(0, 91, 92, 0.85), transparent);
           }
           .header h1 {
               font-size: 32px;
               font-weight: 800;
               color: #fff;
               letter-spacing: 1px;
               text-transform: uppercase;
           }
           .reset-box {
               background: rgba(114, 133, 135, 0.3);
               border-radius: 16px;
               padding: 30px;
               width: 340px;
               box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
               border: 1px solid rgba(0, 91, 92, 0.5);
               text-align: center;
               backdrop-filter: blur(5px);
           }
           .reset-box h1 {
               font-size: 26px;
               font-weight: 900;
               color: #D6EAF8;
               letter-spacing: 2px;
               text-transform: uppercase;
               margin-bottom: 10px;
           }
           .reset-box p {
               font-size: 13px;
               color: #d1d1d1;
               font-weight: 300;
               margin-bottom: 20px;
           }
           .form-group {
               margin-bottom: 20px;
               position: relative;
           }
           .form-group input {
               height: 40px;
               padding: 10px 12px 10px 40px;
               border: none;
               border-radius: 10px;
               width: 100%;
               font-size: 14px;
               background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
               color: #fff;
               transition: all 0.3s ease;
           }
           .form-group input::placeholder { color: transparent; }
           .form-group input:focus {
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
           }
           .form-group:nth-child(1)::before { content: "\f0e0"; }
           .form-group:nth-child(2)::before { content: "\f023"; }
           .form-group:nth-child(3)::before { content: "\f023"; }
           .form-group input:focus ~ ::before { color: #005b5c; }
           .reset-box button.btn {
               width: 100%;
               height: 40px;
               background: linear-gradient(135deg, #005b5c, #003d3e);
               border: none;
               color: #fff;
               font-size: 14px;
               font-weight: 700;
               border-radius: 10px;
               cursor: pointer;
               transition: all 0.3s ease;
           }
           .reset-box button.btn:hover {
               background: linear-gradient(135deg, #003d3e, #ff3333);
               box-shadow: 0 0 20px rgba(0, 91, 92, 0.7);
               transform: translateY(-2px);
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
           .success-message {
               background: rgba(51, 255, 51, 0.2);
               color: #33ff33;
               font-size: 12px;
               padding: 10px;
               border-radius: 8px;
               margin-bottom: 15px;
               text-align: left;
               border: 1px solid rgba(51, 255, 51, 0.3);
           }
           @media (max-width: 768px) {
               .reset-box { width: 90%; padding: 25px; }
               .header { padding: 0 20px; height: 70px; }
               .header h1 { font-size: 26px; }
           }
       </style>
   </head>
   <body>
       <div class="header">
           <h1>Bangladesh Railway</h1>
       </div>
       <div class="reset-box">
           <h1>Reset Password</h1>
           <p>Enter your new password</p>
           @if (session('status'))
               <div class="success-message">{{ session('status') }}</div>
           @endif
           @if (session('error'))
               <div class="error-message">{{ session('error') }}</div>
           @endif
           @if ($errors->any())
               <div class="error-message">
                   @foreach ($errors->all() as $error)
                       {{ $error }}<br>
                   @endforeach
               </div>
           @endif
           <form action="{{ route('password.reset.post') }}" method="post">
               @csrf
               <div class="form-group">
                   <input type="email" name="email" id="email" value="{{ $email }}" required placeholder="Email" readonly>
                   <label for="email">Email</label>
               </div>
               <div class="form-group">
                   <input type="password" name="password" id="password" required placeholder="Password">
                   <label for="password">Password</label>
               </div>
               <div class="form-group">
                   <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirm Password">
                   <label for="password_confirmation">Confirm Password</label>
               </div>
               <button type="submit" class="btn">Reset Password</button>
           </form>
       </div>
   </body>
   </html>