<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-violet-custom to-indigo-700 text-white mb-4">
            <i class="fas fa-user-plus text-xl"></i>
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-2">Créer un compte</h3>
        <p class="text-gray-600">
            Vous avez déjà un compte ? 
            <a href="{{ route('login') }}" class="text-violet-custom hover:text-violet-700 font-semibold transition-colors duration-200">
                Se connecter
            </a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nom et Prénom en ligne -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Nom -->
            <div>
                <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user mr-2 text-violet-custom"></i>
                    Nom
                </label>
                <div class="relative">
                    <x-text-input 
                        id="nom" 
                        class="input-focus block w-full border-2 border-gray-200 rounded-xl p-3 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:outline-none" 
                        type="text" 
                        name="nom" 
                        :value="old('nom')"
                        placeholder="Votre nom"
                        required 
                        autofocus 
                        autocomplete="family-name" 
                    />
                </div>
                <x-input-error :messages="$errors->get('nom')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Prénom -->
            <div>
                <label for="prenom" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user mr-2 text-violet-custom"></i>
                    Prénom
                </label>
                <div class="relative">
                    <x-text-input 
                        id="prenom" 
                        class="input-focus block w-full border-2 border-gray-200 rounded-xl p-3 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:outline-none" 
                        type="text" 
                        name="prenom" 
                        :value="old('prenom')"
                        placeholder="Votre prénom"
                        required 
                        autocomplete="given-name" 
                    />
                </div>
                <x-input-error :messages="$errors->get('prenom')" class="mt-2 text-red-500 text-sm" />
            </div>
        </div>

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
                    :value="old('email')"
                    placeholder="votre@email.com"
                    required 
                    autocomplete="username" 
                />
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                    <i class="fas fa-at text-gray-400"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Filière -->
        <div>
            <label for="id_filiere" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-graduation-cap mr-2 text-violet-custom"></i>
                Filière
            </label>
            <div class="relative">
                <select 
                    id="id_filiere" 
                    name="id_filiere" 
                    required
                    class="input-focus block w-full border-2 border-gray-200 rounded-xl p-4 text-gray-700 bg-white transition-all duration-200 focus:outline-none appearance-none"
                >
                    <option value="">-- Sélectionnez une filière --</option>
                    @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id_filiere }}" {{ old('id_filiere') == $filiere->id_filiere ? 'selected' : '' }}>
                            {{ $filiere->nom_filiere }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('id_filiere')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Mots de passe en ligne -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                        autocomplete="new-password" 
                    />
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                        <i id="togglePassword" class="fas fa-eye cursor-pointer text-gray-400"></i>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2 text-violet-custom"></i>
                    Confirmer le mot de passe
                </label>
                <div class="relative">
                    <x-text-input 
                        id="password_confirmation" 
                        class="input-focus block w-full border-2 border-gray-200 rounded-xl p-4 pr-12 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:outline-none" 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="••••••••"
                        required 
                        autocomplete="new-password" 
                    />
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                        <i id="togglePasswordConfirm" class="fas fa-eye cursor-pointer text-gray-400"></i>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
            </div>
        </div>

        <!-- Checkbox conditions -->
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input 
                    id="terms" 
                    name="terms" 
                    type="checkbox" 
                    required
                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-violet-300 text-violet-custom"
                >
            </div>
            <div class="ml-3 text-sm">
                <label for="terms" class="text-gray-600">
                    J'accepte les 
                    <a href="#" class="text-violet-custom hover:text-violet-700 font-medium">conditions d'utilisation</a> 
                    et la 
                    <a href="#" class="text-violet-custom hover:text-violet-700 font-medium">politique de confidentialité</a>
                </label>
            </div>
        </div>

        <!-- Register Button -->
        <div class="pt-1">
            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-violet-custom to-indigo-700 hover:from-violet-700 hover:to-indigo-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-violet-300"
            >
                <i class="fas fa-user-plus mr-2"></i>
                Créer mon compte
            </button>
        </div>


    </form>

    <!-- Footer -->
    <div class="mt-8 text-center">
        <p class="text-xs text-gray-500">
            En créant un compte, vous acceptez nos 
            <a href="#" class="text-violet-custom hover:text-violet-700">conditions d'utilisation</a> 
            et notre 
            <a href="#" class="text-violet-custom hover:text-violet-700">politique de confidentialité</a>
        </p>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirmInput = document.getElementById('password_confirmation');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        if (togglePasswordConfirm && passwordConfirmInput) {
            togglePasswordConfirm.addEventListener('click', function () {
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        // Password strength indicator (optional)
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                // You can add password strength logic here
            });
        }
    });
    </script>

    <style>
    .input-focus:focus {
        border-color: var(--violet-custom, #8b5cf6);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
    
    /* Custom select arrow */
    select.input-focus {
        background-image: none;
    }
    </style>
</x-guest-layout>