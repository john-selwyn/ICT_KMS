<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Centralized ICT Solutions</title>

    <!--Boxicons CDN-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!--Custom CSS-->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="wrapper register-page">

        <span class="rotate-bg"></span>
        <span class="rotate-bg2"></span>

        <!-- Register Form -->
        <div class="form-box register">
            <h2 class="title animation" style="--i:17; --j:0">Sign Up</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Username Field -->
                <div class="input-box animation" style="--i:18; --j:1">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    <label for="name">Username</label>
                    <i class='bx bxs-user'></i>

                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="input-box animation" style="--i:19; --j:2">
                    <input id="email_register" type="email" name="email" value="{{ old('email') }}" required>
                    <label for="email_register">Email</label>
                    <i class='bx bxs-envelope'></i>

                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="input-box animation" style="--i:20; --j:3">
                    <input id="password_register" type="password" name="password" required>
                    <label for="password_register">Password</label>
                    <i class='bx bxs-lock-alt'></i>

                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="input-box animation" style="--i:21; --j:4">
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                    <label for="password_confirmation">Confirm Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <button type="submit" class="btn animation" style="--i:22;--j:5">Sign Up</button>

                <div class="linkTxt animation" style="--i:23; --j:6">
                    <p>Already have an account? <a href="{{ route('login') }}" class="login-link">Login</a></p>
                </div>
            </form>
        </div>

        <!-- Info Text for Register -->
        <div class="info-text register">
            <img class="animation" style="--i:0; --j:20" src="/images/logo.png" alt="Logo">
            <h2 class="animation" style="--i:17; --j:0;"></h2>
            <p class="animation" style="--i:18; --j:1;">Centralized ICT Solutions and Knowledge Management System</p>
        </div>

    </div>

    <!-- Custom Script -->
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
