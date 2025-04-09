<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Splitify') }} - Login</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --teal: #00B2A9;
            --navy: #1A2B63;
            --coral: #FF5757;
            --light-gray: #f5f5f7;
            --dark-gray: #2c2c2e;
            --gradient-primary: linear-gradient(135deg, var(--teal), var(--navy));
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #f8fafb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            max-width: 480px;
            width: 100%;
            padding: 2rem;
        }
        
        .login-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            padding: 2rem;
        }
        
        .logo-container {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            color: #4a5568;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            outline: none;
            transition: all 0.2s;
        }
        
        .form-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 2px rgba(0, 178, 169, 0.2);
        }
        
        .error-message {
            color: var(--coral);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .splitify-btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
            border: none;
            font-size: 1rem;
        }
        
        .splitify-btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 14px rgba(0, 178, 169, 0.3);
        }
        
        .splitify-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 178, 169, 0.4);
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .remember-me input {
            border-radius: 0.25rem;
            border-color: #e2e8f0;
        }
        
        .remember-me span {
            margin-left: 0.5rem;
            font-size: 0.875rem;
            color: #4a5568;
        }
        
        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--teal);
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #4a5568;
        }
        
        .register-link a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <a href="/">
                <span class="text-4xl font-bold" style="color: var(--navy);">Splitify</span>
            </a>
        </div>
        
        <div class="login-card">
            <h2 class="text-2xl font-bold mb-6 text-center" style="color: var(--navy);">Welcome back</h2>
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Remember Me -->
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300" name="remember">
                    <span>{{ __('Remember me') }}</span>
                </div>
                
                <button type="submit" class="splitify-btn splitify-btn-primary">
                    {{ __('Log in') }}
                </button>
                
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </form>
        </div>
        
        <div class="register-link">
            {{ __('Don\'t have an account?') }} 
            <a href="{{ route('register') }}">{{ __('Register') }}</a>
        </div>
    </div>
</body>
</html>
