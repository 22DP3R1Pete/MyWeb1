<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Splitify - Workout Split Planning & Tracking</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <style>
        /* Splitify Brand Colors */
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
            color: #333;
            line-height: 1.6;
        }
        
        // ... existing code ...
        /* Navigation Styles */
        .splitify-nav {
            padding: 1.5rem 0;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
        }
        
        .splitify-nav .logo {
            font-weight: 700;
            font-size: 1.75rem;
            color: var(--navy);
            letter-spacing: -0.5px;
        }
        
        @media (max-width: 768px) {
            .splitify-nav {
                background-color: rgba(255, 255, 255, 0.95);
                padding: 1rem 0;
                position: fixed;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            
            .splitify-nav .logo {
                font-size: 1.5rem;
            }
        }
        
        .splitify-container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        /* Hero Styles */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-color: var(--light-gray);
            position: relative;
            overflow: hidden;
            padding: 6rem 0 4rem;
        }
        
        .hero-content {
            z-index: 2;
            max-width: 580px;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--navy);
        }
        
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            color: #4a4a4a;
        }
        
        .hero-image {
            position: absolute;
            right: -50px;
            top: 50%;
            transform: translateY(-50%);
            width: 45%;
            max-width: 600px;
            z-index: 1;
        }
        
        @media (max-width: 1024px) {
            .hero-image {
                opacity: 0.3;
                width: 70%;
                right: -100px;
            }
            
            .hero-content {
                max-width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.125rem;
            }
        }
        
        /* Button Styles */
        .btn {
            display: inline-block;
            padding: 0.875rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 14px rgba(0, 178, 169, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 178, 169, 0.6);
        }
        
        .btn-secondary {
            background: white;
            color: var(--navy);
            border: 2px solid var(--navy);
            margin-left: 1rem;
        }
        
        .btn-secondary:hover {
            background: var(--navy);
            color: white;
        }
        
        /* Features Section */
        .features {
            padding: 6rem 0;
            background-color: white;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-header h2 {
            font-size: 2.5rem;
            color: var(--navy);
            margin-bottom: 1rem;
        }
        
        .section-header p {
            font-size: 1.25rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
        }
        
        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            background: var(--gradient-primary);
        }
        
        .feature-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--navy);
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.7;
        }
        
        /* How It Works Section */
        .how-it-works {
            padding: 6rem 0;
            background-color: var(--light-gray);
        }
        
        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }
        
        .step {
            text-align: center;
            position: relative;
        }
        
        .step-number {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            margin: 0 auto 1.5rem;
        }
        
        .step h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--navy);
        }
        
        .step p {
            color: #666;
        }
        
        /* Splits Showcase */
        .splits-showcase {
            padding: 6rem 0;
            background-color: white;
        }
        
        .splits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .split-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .split-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        
        .split-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .split-card-content {
            padding: 1.5rem;
        }
        
        .split-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: var(--navy);
        }
        
        .split-card p {
            color: #666;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        .split-details {
            display: flex;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid #eee;
            color: var(--teal);
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        /* Testimonials Section */
        .testimonials {
            padding: 6rem 0;
            background-color: var(--light-gray);
        }
        
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        
        .testimonial-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 1rem;
        }
        
        .testimonial-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .testimonial-author h4 {
            font-size: 1.125rem;
            margin-bottom: 0.25rem;
            color: var(--navy);
        }
        
        .testimonial-author p {
            font-size: 0.875rem;
            color: #666;
        }
        
        .testimonial-rating {
            display: flex;
            color: var(--coral);
            margin-bottom: 1rem;
        }
        
        .testimonial-text {
            color: #444;
            font-style: italic;
            line-height: 1.7;
        }
        
        /* Final CTA Section */
        .cta {
            padding: 8rem 0;
            background: var(--gradient-primary);
            color: white;
            text-align: center;
        }
        
        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }
        
        .cta p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta .btn-primary {
            background: white;
            color: var(--navy);
            box-shadow: 0 4px 14px rgba(255, 255, 255, 0.3);
        }
        
        .cta .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.5);
        }
        
        /* Footer */
        .footer {
            background-color: var(--navy);
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }
        
        .footer-logo {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
        }
        
        .footer h4 {
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
            color: var(--teal);
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .footer-social {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .footer-social a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        
        .footer-social a:hover {
            background: var(--teal);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="splitify-nav">
        <div class="splitify-container">
            <div class="flex justify-between items-center">
                <a href="#" class="logo">Splitify</a>
                
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <!-- Desktop navigation -->
                <div class="hidden md:flex items-center">
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-navy font-medium mr-4">Log in</a>
                                
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary">Sign up</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Mobile navigation menu -->
            <div id="mobile-menu" class="md:hidden hidden mt-4 bg-white rounded-lg shadow-lg p-4">
                @if (Route::has('login'))
                    <div class="flex flex-col space-y-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-secondary w-full text-center">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-navy font-medium text-center py-2">Log in</a>
                            
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary w-full text-center">Sign up</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="splitify-container">
            <div class="flex flex-col items-center text-center md:items-start md:text-left">
                <div class="hero-content w-full md:w-auto">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight">Build Your Perfect Workout Split</h1>
                    <p class="text-lg md:text-xl mt-4 md:mt-6">Splitify helps you plan, track, and optimize your workout routine. Create custom splits, track your progress, and achieve your fitness goals faster.</p>
                    <div class="flex flex-col sm:flex-row mt-6 md:mt-8 gap-4">
                        <a href="{{ route('register') }}" class="btn btn-primary w-full sm:w-auto text-center">Get Started</a>
                        <a href="#how-it-works" class="btn btn-secondary w-full sm:w-auto text-center mt-4 sm:mt-0 sm:ml-0 md:ml-4">How It Works</a>
                    </div>
                </div>
                <div class="hero-image md:absolute relative mt-12 md:mt-0 w-full md:w-auto max-w-md mx-auto">
                    <img class="rounded-lg shadow-xl" src="https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Person working out" />
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features py-12 md:py-16 lg:py-20">
        <div class="splitify-container">
            <div class="section-header">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold">Powerful Features</h2>
                <p class="text-base md:text-lg lg:text-xl mt-4">Everything you need to create and maintain your perfect workout routine</p>
            </div>
            
            <div class="features-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 mt-12">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl">Custom Split Creation</h3>
                    <p>Design your own workout splits or choose from our proven templates. Customize days, exercises, sets, and reps to fit your goals.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl">Progress Tracking</h3>
                    <p>Log your workouts and track your progress over time. See your strength gains, volume increases, and body composition changes.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl">Extensive Exercise Library</h3>
                    <p>Access our comprehensive library of exercises with detailed instructions, video demonstrations, and muscle targeting information.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl">Smart Recommendations</h3>
                    <p>Get AI-powered suggestions to improve your workout split based on your performance, goals, and available equipment.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works py-12 md:py-16 lg:py-20" id="how-it-works">
        <div class="splitify-container">
            <div class="section-header">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold">How Splitify Works</h2>
                <p class="text-base md:text-lg lg:text-xl mt-4">Start optimizing your workout routine in just a few simple steps</p>
            </div>
            
            <div class="steps grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-12">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3 class="text-lg md:text-xl lg:text-2xl">Create Your Account</h3>
                    <p>Sign up for free and set your fitness goals, experience level, and preferences.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <h3 class="text-lg md:text-xl lg:text-2xl">Design Your Split</h3>
                    <p>Create a custom workout split or choose from our professionally designed templates.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <h3 class="text-lg md:text-xl lg:text-2xl">Track Your Workouts</h3>
                    <p>Log your exercises, sets, and reps to track your progress over time.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">4</div>
                    <h3 class="text-lg md:text-xl lg:text-2xl">Optimize & Improve</h3>
                    <p>Analyze your performance data and get recommendations to optimize your training.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Splits Showcase Section -->
    <section class="splits-showcase">
        <div class="splitify-container">
            <div class="section-header">
                <h2>Popular Workout Splits</h2>
                <p>Discover proven workout splits used by fitness enthusiasts worldwide</p>
            </div>
            
            <div class="splits-grid">
                <div class="split-card">
                    <img src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80" alt="Push Pull Legs Split">
                    <div class="split-card-content">
                        <h3>Push/Pull/Legs (PPL)</h3>
                        <p>A 6-day split that targets push muscles (chest, shoulders, triceps), pull muscles (back, biceps), and legs.</p>
                        <div class="split-details">
                            <span>6 days/week</span>
                            <span>Intermediate</span>
                        </div>
                    </div>
                </div>
                
                <div class="split-card">
                    <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Upper Lower Split">
                    <div class="split-card-content">
                        <h3>Upper/Lower Split</h3>
                        <p>A 4-day split alternating between upper body workouts and lower body workouts.</p>
                        <div class="split-details">
                            <span>4 days/week</span>
                            <span>All Levels</span>
                        </div>
                    </div>
                </div>
                
                <div class="split-card">
                    <img src="https://images.unsplash.com/photo-1584863265045-f9d10ddba637?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Full Body Split">
                    <div class="split-card-content">
                        <h3>Full Body Split</h3>
                        <p>A 3-day full body workout targeting all major muscle groups in each session.</p>
                        <div class="split-details">
                            <span>3 days/week</span>
                            <span>Beginner</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials py-12 md:py-16 lg:py-20">
        <div class="splitify-container">
            <div class="section-header">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold">What Our Users Say</h2>
                <p class="text-base md:text-lg lg:text-xl mt-4">Join thousands of satisfied users who have transformed their fitness journey</p>
            </div>
            
            <div class="testimonials-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mt-12">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>"Splitify has completely transformed how I organize my workouts. The split templates are fantastic, and the progress tracking keeps me motivated."</p>
                    </div>
                    <div class="testimonial-author flex items-center mt-4">
                        <div class="testimonial-avatar">
                            <div class="avatar-placeholder"></div>
                        </div>
                        <div class="testimonial-info ml-3">
                            <h4 class="testimonial-name">Alex Johnson</h4>
                            <p class="testimonial-title">Fitness Enthusiast</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>"As a personal trainer, I recommend Splitify to all my clients. It's user-friendly, comprehensive, and makes tracking progress so much easier than spreadsheets."</p>
                    </div>
                    <div class="testimonial-author flex items-center mt-4">
                        <div class="testimonial-avatar">
                            <div class="avatar-placeholder"></div>
                        </div>
                        <div class="testimonial-info ml-3">
                            <h4 class="testimonial-name">Sarah Williams</h4>
                            <p class="testimonial-title">Certified Personal Trainer</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>"I've tried many fitness apps, but Splitify stands out with its customization options. Creating my PPL split was simple, and the analytics help me see where I'm improving."</p>
                    </div>
                    <div class="testimonial-author flex items-center mt-4">
                        <div class="testimonial-avatar">
                            <div class="avatar-placeholder"></div>
                        </div>
                        <div class="testimonial-info ml-3">
                            <h4 class="testimonial-name">Michael Chen</h4>
                            <p class="testimonial-title">Competitive Powerlifter</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta py-12 md:py-16 lg:py-20">
        <div class="splitify-container">
            <div class="cta-container bg-primary-600 rounded-3xl p-6 md:p-10 lg:p-16 text-white text-center">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold">Ready to Transform Your Workout Routine?</h2>
                <p class="text-base md:text-lg lg:text-xl mt-4 max-w-2xl mx-auto">Join Splitify today and take your training to the next level with smart workout splits, progress tracking, and personalized recommendations.</p>
                <div class="mt-8">
                    <a href="{{ route('register') }}" class="btn-primary bg-white text-primary-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold text-base md:text-lg transition">Get Started Free</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="splitify-container">
            <div class="footer-grid">
                <div>
                    <div class="footer-logo">Splitify</div>
                    <p>Build your perfect workout split, track your progress, and achieve your fitness goals.</p>
                    <div class="footer-social">
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg></a>
                    </div>
                </div>
                
                <div>
                    <h4>Company</h4>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Press</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4>Resources</h4>
                    <ul class="footer-links">
                        <li><a href="#">Workout Splits</a></li>
                        <li><a href="#">Exercise Library</a></li>
                        <li><a href="#">Nutrition Guides</a></li>
                        <li><a href="#">Fitness Tips</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4>Support</h4>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Splitify. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile navigation toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
