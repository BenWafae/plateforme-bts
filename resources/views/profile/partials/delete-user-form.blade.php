<section class="space-y-6 max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-10 border border-[#C0C0F0]">
    <header>
        <h2 class="text-xl font-bold text-[#7879E3]">
            Supprimer le compte
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-[#7879E3] hover:bg-[#6566d4] focus:ring-[#B1B3E0] transition-colors"
    >
        Supprimer le compte
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white rounded-lg shadow-md border border-[#C0C0F0] max-w-lg mx-auto">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-[#7879E3]">
                Êtes-vous sûr de vouloir supprimer votre compte ?
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Mot de passe" class="sr-only text-[#7879E3]" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 rounded-lg border border-[#B1B3E0] focus:border-[#7879E3] focus:ring-[#7879E3]"
                    placeholder="Mot de passe"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[#E00]" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="border border-[#7879E3] text-[#7879E3] hover:bg-[#E0E0FF] transition-colors">
                    Annuler
                </x-secondary-button>

                <x-danger-button class="bg-[#E53E3E] hover:bg-[#C53030] focus:ring-red-300 transition-colors">
                    Supprimer le compte
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
