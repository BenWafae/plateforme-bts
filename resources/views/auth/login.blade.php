<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-violet-custom to-indigo-700 text-white mb-4">
            <i class="fas fa-user text-xl"></i>
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-2">Se connecter</h3>
        <p class="text-gray-600">
            Vous n'avez pas de compte ? 
            <a href="{{ route('register') }}" class="text-violet-custom hover:text-violet-700 font-semibold transition-colors duration-200">
                S'inscrire
            </a>
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-envelope mr-2 text-violet-custom"></i>
                Adresse email
            </label>
            <div class="relative">
                <x-text-input 
                    id="email" 
                    class="input-focus block w-full border-2 border-gray-200 rounded-xl p-4 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:outline-none" 
                    type="email" 
                    name="email" 
                    placeholder="votre@email.com"
                    required 
                    autofocus 
                    autocomplete="username" 
                />
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                    <i class="fas fa-at text-gray-400"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-violet-custom"></i>
                Mot de passe
            </label>
            <div class="relative">
                <x-text-input 
                    id="password" 
                    class="input-focus block w-full border-2 border-gray-200 rounded-xl p-4 pr-12 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:outline-none" 
                    type="password" 
                    name="password" 
                    placeholder="••••••••"
                    required 
                    autocomplete="current-password" 
                />
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                   <i id="togglePassword" class="fas fa-eye cursor-pointer text-gray-400"></i>

                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" class="rounded border-gray-300 text-violet-custom shadow-sm focus:ring-violet-custom">
                <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-violet-custom hover:text-violet-700 font-medium transition-colors duration-200" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="pt-2">
            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-violet-custom to-indigo-700 hover:from-violet-700 hover:to-indigo-800 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-violet-300"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>
                Se connecter
            </button>
        </div>

        <!-- Séparateur -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500">ou</span>
            </div>
        </div>

        <!-- Boutons sociaux (optionnel) -->
        <div class="grid grid-cols-2 gap-4">
            <button type="button" class="flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                <i class="fab fa-google text-red-500 mr-2"></i>
                <span class="text-sm font-medium text-gray-700">Google</span>
            </button>
            <button type="button" class="flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                <i class="fab fa-microsoft text-blue-500 mr-2"></i>
                <span class="text-sm font-medium text-gray-700">Microsoft</span>
            </button>
        </div>
    </form>

    <!-- Footer -->
    <div class="mt-8 text-center">
        <p class="text-xs text-gray-500">
            En vous connectant, vous acceptez nos 
            <a href="#" class="text-violet-custom hover:text-violet-700">conditions d'utilisation</a> 
            et notre 
            <a href="#" class="text-violet-custom hover:text-violet-700">politique de confidentialité</a>
        </p>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>

</x-guest-layout>






