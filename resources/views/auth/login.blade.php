
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f2f5;
            overflow-x: hidden;
            padding: 1rem;
        }

        .wrapper {
            position: relative;
            width: 100%;
            max-width: 1170px;
            min-height: 500px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem;
            overflow: hidden;
        }

        .rotate-bg, .rotate-bg2 {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(45deg, #4481eb, #04befe);
            border-radius: 50%;
            z-index: 0;
        }

        .rotate-bg {
            top: -250px;
            right: -250px;
        }

        .rotate-bg2 {
            bottom: -250px;
            left: -250px;
        }

        .form-box {
            position: relative;
            width: 50%;
            padding: 1.5rem;
            z-index: 1;
        }

        .info-text {
            position: relative;
            width: 45%;
            padding: 1.5rem;
            text-align: center;
            z-index: 1;
            color: #fff;
        }

        .info-text img {
            width: 200px;
            max-width: 100%;
            height: auto;
            margin-bottom: 1rem;
        }

        .title {
            font-size: clamp(1.5rem, 4vw, 2rem);
            color: #333;
            margin-bottom: 1.5rem;
        }

        .input-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-box input {
            width: 100%;
            padding: 0.8rem 2.5rem 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            font-size: 1rem;
            transition: 0.3s;
        }

        .input-box label {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #999;
            transition: 0.3s;
            background: #fff;
            padding: 0 0.4rem;
        }

        .input-box input:focus ~ label,
        .input-box input:valid ~ label,
        .input-box input.focused ~ label {
            top: 0;
            left: 0.8rem;
            font-size: 0.75rem;
        }

        .input-box i {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn {
            width: 100%;
            padding: 0.8rem;
            background: #4481eb;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #2d6ad9;
        }

        .linkTxt {
            margin-top: 1rem;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }

        .linkTxt a {
            color: #4481eb;
            text-decoration: none;
            font-weight: 500;
        }

        .error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .animation {
            opacity: 0;
            transform: translateX(100px);
            animation: fade-in 0.5s forwards;
        }

        @keyframes fade-in {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
                height: auto;
                min-height: auto;
                margin: 1rem 0;
            }

            .form-box,
            .info-text {
                width: 100%;
                padding: 1rem;
            }

            .info-text {
                order: -1;
                margin-bottom: 1rem;
                background: linear-gradient(45deg, #4481eb, #04befe);
                border-radius: 12px;
            }

            .rotate-bg,
            .rotate-bg2 {
                display: none;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 0.5rem;
            }

            .wrapper {
                border-radius: 16px;
                padding: 1rem;
            }

            .form-box,
            .info-text {
                padding: 0.75rem;
            }

            .input-box {
                margin-bottom: 1rem;
            }

            .input-box input {
                padding: 0.7rem 2rem 0.7rem 0.8rem;
                font-size: 0.95rem;
            }

            .remember-forgot {
                font-size: 0.85rem;
            }

            .btn {
                padding: 0.7rem;
                font-size: 0.95rem;
            }

            .linkTxt {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <span class="rotate-bg"></span>
        <span class="rotate-bg2"></span>

        <div class="form-box login">
            <h2 class="title animation">Login</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-box animation">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           required autofocus autocomplete="username"
                           class="@error('email') is-invalid @enderror">
                    <label for="email">Email</label>
                    <i class='bx bxs-user'></i>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-box animation">
                    <input id="password" type="password" name="password" 
                           required autocomplete="current-password"
                           class="@error('password') is-invalid @enderror">
                    <label for="password">Password</label>
                    <i class='bx bxs-lock-alt'></i>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-forgot animation">
                    <label for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember" 
                               {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn animation">Login</button>

                <div class="linkTxt animation">
                    <p>Don't have an account? <a href="{{ route('register') }}" class="register-link">Sign Up</a></p>
                </div>
            </form>
        </div>

        <div class="info-text login">
            <img class="animation" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }} Logo">
            <p class="animation">Centralized ICT Solutions and Knowledge Management System</p>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add animation delay based on element position
        document.querySelectorAll('.animation').forEach((element, index) => {
            element.style.animationDelay = `${index * 0.1}s`;
        });

        // Floating labels
        document.querySelectorAll('.input-box input').forEach(input => {
            input.addEventListener('focus', () => {
                input.classList.add('focused');
            });

            input.addEventListener('blur', () => {
                if (!input.value) {
                    input.classList.remove('focused');
                }
            });

            // Check on load if input has value
            if (input.value) {
                input.classList.add('focused');
            }
        });
    </script>
    @endpush
</body>
</html>
