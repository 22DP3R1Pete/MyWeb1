<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Splitify') }} - Profile</title>
    
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
        }
        
        .content-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .profile-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }
        
        .profile-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0.5rem;
        }
        
        .section-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 1.5rem;
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
        
        .form-input, .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            outline: none;
            transition: all 0.2s;
        }
        
        .form-input:focus, .form-textarea:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 2px rgba(0, 178, 169, 0.2);
        }
        
        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .error-message {
            color: var(--coral);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .splitify-btn {
            display: inline-block;
            padding: 0.625rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-size: 0.875rem;
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
        
        .splitify-btn-secondary {
            background: white;
            color: var(--navy);
            border: 2px solid var(--navy);
        }
        
        .splitify-btn-secondary:hover {
            background: var(--navy);
            color: white;
        }
        
        .splitify-btn-danger {
            background: white;
            color: var(--coral);
            border: 2px solid var(--coral);
        }
        
        .splitify-btn-danger:hover {
            background: var(--coral);
            color: white;
        }
        
        .status-message {
            font-size: 0.875rem;
            color: #059669;
            margin-left: 1rem;
        }
        
        .section-divider {
            border-top: 1px solid #e2e8f0;
            margin: 1.5rem 0;
        }
        
        /* Navigation bar styling */
        .navbar {
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1A2B63;
            text-decoration: none;
        }
        
        .navbar-center {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            margin-left: auto;
            margin-right: auto;
        }

        .navbar-right {
            display: flex;
            align-items: center;
        }
        
        .navbar-link {
            font-size: 0.9rem;
            color: #6B7280;
            text-decoration: none;
            transition: color 0.2s;
            display: inline-block;
            padding: 0.5rem 0;
        }
        
        .navbar-link:hover {
            color: var(--teal);
        }
        
        .logout-btn {
            font-size: 0.9rem;
            color: #6B7280;
            background: none;
            border: none;
            padding: 0.5rem 0;
            cursor: pointer;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        
        .logout-btn:hover {
            color: var(--teal);
        }

        .dropdown-icon {
            width: 16px;
            height: 16px;
        }
        
        /* Modal styling */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }
        
        .modal-content {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 2rem;
        }
        
        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0.5rem;
        }
        
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="navbar-container">
            <a href="{{ route('dashboard') }}" class="navbar-brand">Splitify</a>
            <div class="navbar-center">
                <a href="{{ route('workout-plans.index') }}" class="navbar-link">Workout Plans</a>
                <a href="{{ route('exercises.index') }}" class="navbar-link">Exercise Library</a>
                <a href="{{ route('progress.index') }}" class="navbar-link">Progress</a>
            </div>
            <div class="navbar-right">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" type="button" class="logout-btn">
                        <span>{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" style="display: none;">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-container">
        <h2 class="text-2xl font-bold mb-6" style="color: var(--navy);">Profile Settings</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left column (wider) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Update Profile Information -->
                <div class="profile-card">
                    <h3 class="section-title">{{ __('Profile Information') }}</h3>
                    <p class="section-subtitle">{{ __("Update your account's profile information and email address.") }}</p>
                    
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>
                
                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')
                
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                            @error('name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                            @error('email')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                
                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-sm text-gray-800">
                                        {{ __('Your email address is unverified.') }}
                
                                        <button form="send-verification" class="text-sm text-teal-600 hover:text-teal-900 underline">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>
                
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-600">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                
                        <div class="flex items-center">
                            <button type="submit" class="splitify-btn splitify-btn-primary">{{ __('Save') }}</button>
                
                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="status-message"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right column (narrower) -->
            <div class="space-y-6">
                <!-- Update Password -->
                <div class="profile-card">
                    <h3 class="section-title">{{ __('Update Password') }}</h3>
                    <p class="section-subtitle">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                    
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')
                
                        <div class="form-group">
                            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password" />
                            @error('current_password', 'updatePassword')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                            <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password" />
                            @error('password', 'updatePassword')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password" />
                            @error('password_confirmation', 'updatePassword')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <div class="flex items-center">
                            <button type="submit" class="splitify-btn splitify-btn-primary">{{ __('Save') }}</button>
                
                            @if (session('status') === 'password-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="status-message"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
                
                <!-- Delete Account -->
                <div class="profile-card">
                    <h3 class="section-title">{{ __('Delete Account') }}</h3>
                    <p class="section-subtitle">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
                    
                    <button 
                        class="splitify-btn splitify-btn-danger w-full mt-4"
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    >{{ __('Delete Account') }}</button>
                
                    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                            @csrf
                            @method('delete')
                
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Are you sure you want to delete your account?') }}
                            </h2>
                
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            </p>
                
                            <div class="mt-6">
                                <label for="password" class="form-label sr-only">{{ __('Password') }}</label>
                                
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="form-input"
                                    placeholder="{{ __('Password') }}"
                                />
                
                                @error('password', 'userDeletion')
                                    <p class="error-message mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <div class="mt-6 flex justify-end">
                                <button type="button" class="splitify-btn splitify-btn-secondary" x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </button>
                
                                <button type="submit" class="splitify-btn splitify-btn-danger ml-3">
                                    {{ __('Delete Account') }}
                                </button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
