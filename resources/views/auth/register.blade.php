<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Height -->
        <div class="mt-4">
            <x-input-label for="height" :value="__('Height (cm)')" />
            <x-text-input id="height" class="block mt-1 w-full" type="number" step="0.01" name="height" :value="old('height')" />
            <x-input-error :messages="$errors->get('height')" class="mt-2" />
        </div>

        <!-- Weight -->
        <div class="mt-4">
            <x-input-label for="weight" :value="__('Weight (kg)')" />
            <x-text-input id="weight" class="block mt-1 w-full" type="number" step="0.01" name="weight" :value="old('weight')" />
            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
        </div>

        <!-- Birth Year -->
        <div class="mt-4">
            <x-input-label for="birth_year" :value="__('Birth Year')" />
            <x-text-input id="birth_year" class="block mt-1 w-full" type="number" min="1900" max="{{ date('Y') }}" name="birth_year" :value="old('birth_year')" />
            <x-input-error :messages="$errors->get('birth_year')" class="mt-2" />
        </div>

        <!-- Fitness Goals -->
        <div class="mt-4">
            <x-input-label for="fitness_goals" :value="__('Fitness Goals')" />
            <textarea id="fitness_goals" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="fitness_goals">{{ old('fitness_goals') }}</textarea>
            <x-input-error :messages="$errors->get('fitness_goals')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
