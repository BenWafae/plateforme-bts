<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col items-center">
        <h3 class="text-3xl font-semibold">Se connecter</h3>
        <p class="text-gray-500">Vous n’avez pas de compte ? <a href="#" style="color: oklch(0.702 0.183 293.541);">S'inscrire</a></p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="w-full sm:max-w-md mt-6 mx-auto">
        @csrf

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="text-sm font-semibold" style="color: #4B4B4B;">email</label>
            <x-text-input id="email" class="block w-full border-gray-300 rounded-md p-3" type="email" name="email"  required autofocus autocomplete="username" style="color: #4B4B4B;" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <label for="password" class="text-sm font-semibold" style="color: #4B4B4B;">mot de passe</label>
            <x-text-input id="password" class="block w-full border-gray-300 rounded-md p-3 pr-10" type="password" name="password" required autocomplete="current-password" style="color: #4B4B4B;" />
            {{-- <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" onclick="togglePasswordVisibility()"> --}}
                {{-- <svg id="password-icon" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12c0-3-2.5-6-5-6s-5 3-5 6 2.5 6 5 6 5-3 5-6z" />
                </svg> --}}
            </button>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Forgot Password -->
        <div class="mt-2 text-right">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-500 hover:text-gray-700" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="mt-4">
            <button type="submit" class="w-full p-2 rounded-md text-white" style="background-color: oklch(0.702 0.183 293.541); font-size: 14px;">
                Se connecter
            </button>
        </div>
    </form>
</x-guest-layout>







