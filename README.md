# Splitify - Workout Management Application

## Overview
Splitify is a comprehensive workout management web application built with Laravel. It helps users create, manage, and track their workout routines, exercise progress, and fitness goals.

## Features

### Workout Plan Management
- Create customized workout plans with specified duration and difficulty levels
- Organize exercises by training days (splits)
- Set exercise parameters including sets, reps, and rest periods
- Edit and update existing workout plans

### Exercise Library
- Browse a comprehensive database of exercises
- Filter exercises by muscle groups, equipment, and difficulty
- Add custom exercises to your personal library

### Progress Tracking
- Log completed workouts
- Track performance metrics (weight, reps, sets)
- Visualize progress with performance charts
- Monitor workout streaks and adherence to plans

### Dashboard
- View workout statistics and progress metrics
- See weekly workout completion rates
- Track total volume lifted and volume change percentage
- Display current workout streak
- View recent workout history

## Getting Started

### Prerequisites
- PHP 8.0+
- Composer
- MySQL or compatible database
- Node.js and NPM

### Installation
1. Clone the repository
2. Install PHP dependencies:
   ```
   composer install
   ```
3. Install JavaScript dependencies:
   ```
   npm install
   ```
4. Create and configure your .env file:
   ```
   cp .env.example .env
   ```
5. Generate application key:
   ```
   php artisan key:generate
   ```
6. Run database migrations and seeders:
   ```
   php artisan migrate --seed
   ```
7. Build frontend assets:
   ```
   npm run dev
   ```
8. Start the development server:
   ```
   php artisan serve
   ```

## Usage
After installation, you can access the application at `http://localhost:8000`. 

1. Register for a new account or log in with existing credentials
2. Navigate to the dashboard to see your workout statistics
3. Create workout plans in the "Workout Plans" section
4. Log your workouts in the "Progress" section
5. Track your performance over time with the built-in analytics

## Technology Stack
- **Backend**: Laravel PHP Framework
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Breeze

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
