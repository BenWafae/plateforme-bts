<section class="bg-white shadow-xl rounded-2xl p-8 max-w-4xl mx-auto mt-10 border border-[#C0C0F0]">
    <header class="mb-6 border-b" style="border-color: #A5A6E3; padding-bottom: 1rem;">
        <h2 class="text-xl font-bold text-[#7879E3]">
            Mise à jour du mot de passe
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" value="Mot de passe actuel" class="text-[#7879E3]" />
            <x-text-input 
                id="current_password" name="current_password" type="password" 
                class="mt-1 block w-full rounded-lg border border-[#B1B3E0] focus:border-[#7879E3] focus:ring-[#7879E3]" 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[#E00]" />
        </div>

        <div>
            <x-input-label for="password" value="Nouveau mot de passe" class="text-[#7879E3]" />
            <x-text-input 
                id="password" name="password" type="password" 
                class="mt-1 block w-full rounded-lg border border-[#B1B3E0] focus:border-[#7879E3] focus:ring-[#7879E3]" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[#E00]" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" class="text-[#7879E3]" />
            <x-text-input 
                id="password_confirmation" name="password_confirmation" type="password" 
                class="mt-1 block w-full rounded-lg border border-[#B1B3E0] focus:border-[#7879E3] focus:ring-[#7879E3]" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[#E00]" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-[#7879E3] hover:bg-[#6566d4] focus:ring-[#B1B3E0]">
                Enregistrer
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >Enregistré.</p>
            @endif
        </div>
    </form>
</section>
