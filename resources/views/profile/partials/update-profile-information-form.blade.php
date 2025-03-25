<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

        <!-- Fitness Profile Section -->
        <div class="border-t border-gray-200 pt-4 mt-4">
            <h3 class="font-medium text-base text-gray-900">{{ __('Fitness Profile') }}</h3>
            
            <div class="mt-3">
                <x-input-label for="height" :value="__('Height (cm)')" />
                <x-text-input id="height" name="height" type="number" step="0.01" class="mt-1 block w-full" :value="old('height', $user->height)" />
                <x-input-error class="mt-2" :messages="$errors->get('height')" />
            </div>
            
            <div class="mt-3">
                <x-input-label for="weight" :value="__('Weight (kg)')" />
                <x-text-input id="weight" name="weight" type="number" step="0.01" class="mt-1 block w-full" :value="old('weight', $user->weight)" />
                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
            </div>
            
            <div class="mt-3">
                <x-input-label for="birth_year" :value="__('Birth Year')" />
                <x-text-input id="birth_year" name="birth_year" type="number" min="1900" max="{{ date('Y') }}" class="mt-1 block w-full" :value="old('birth_year', $user->birth_year)" />
                <x-input-error class="mt-2" :messages="$errors->get('birth_year')" />
                @if ($user->birth_year)
                    <p class="text-sm text-gray-600 mt-1">Age: {{ $user->age }}</p>
                @endif
            </div>
            
            <div class="mt-3">
                <x-input-label for="fitness_goals" :value="__('Fitness Goals')" />
                <textarea id="fitness_goals" name="fitness_goals" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('fitness_goals', $user->fitness_goals) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('fitness_goals')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
