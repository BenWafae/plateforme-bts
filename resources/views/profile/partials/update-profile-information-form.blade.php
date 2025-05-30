<section class="flex items-center justify-center min-h-screen bg-gray-50">
  <div class="bg-white shadow-xl rounded-2xl p-8 max-w-4xl w-full border border-[#C0C0F0]">
    <header class="mb-8 border-b" style="border-color: #A5A6E3; padding-bottom: 1rem;">
      <h2 class="text-3xl font-bold text-[#7879E3]">
        Informations du profil
      </h2>
      <p class="mt-1 text-sm text-gray-600">
        Mettez à jour vos informations personnelles et votre adresse e-mail.
      </p>
    </header>

    <!-- Formulaire de vérification d'email -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
      @csrf
    </form>

    <!-- Formulaire de mise à jour -->
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
      @csrf
      @method('patch')

      <!-- Avatar avec initiale -->
      <div class="flex items-center space-x-5">
        <div class="w-16 h-16 bg-[#7879E3] text-white text-2xl font-semibold rounded-full flex items-center justify-center shadow-md">
          {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>

        <div class="w-full">
          <x-input-label for="name" :value="'Nom complet'" class="text-[#7879E3]" />
          <x-text-input
            id="name" name="name" type="text"
            class="mt-1 block w-full rounded-lg border border-[#B1B3E0] focus:border-[#7879E3] focus:ring-[#7879E3]"
            :value="old('name', $user->name)" required autofocus autocomplete="name"
          />
          <x-input-error class="mt-2 text-[#E00]" :messages="$errors->get('name')" />
        </div>
      </div>

      <!-- Email -->
      <div>
        <x-input-label for="email" :value="'Adresse e-mail'" class="text-[#7879E3]" />
        <x-text-input
          id="email" name="email" type="email"
          class="mt-1 block w-full rounded-lg border border-[#B1B3E0] focus:border-[#7879E3] focus:ring-[#7879E3]"
          :value="old('email', $user->email)" required autocomplete="username"
        />
        <x-input-error class="mt-2 text-[#E00]" :messages="$errors->get('email')" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
          <div class="mt-2 text-sm text-gray-700">
            <p>
              Votre adresse e-mail n’est pas vérifiée.

              <button form="send-verification" class="ml-2 underline text-[#7879E3] hover:text-[#5F60B8]">
                Cliquez ici pour renvoyer l’e-mail de vérification.
              </button>
            </p>

            @if (session('status') === 'verification-link-sent')
              <p class="mt-2 font-medium text-sm text-green-600">
                Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
              </p>
            @endif
          </div>
        @endif
      </div>

      <!-- Mot de passe -->
      <div>
        <x-input-label for="password" :value="'Mot de passe'" class="text-[#7879E3]" />
        <x-text-input
          id="password" name="password" type="password"
          class="mt-1 block w-full rounded-lg border border-[#B1B3E0] focus:border-[#7879E3] focus:ring-[#7879E3]"
          autocomplete="new-password"
        />
        <x-input-error class="mt-2 text-[#E00]" :messages="$errors->get('password')" />
        <p class="mt-2 text-sm text-gray-500">
          Laissez ce champ vide si vous ne souhaitez pas changer votre mot de passe.
        </p>
      </div>

      <!-- Boutons -->
      <div class="flex items-center gap-4">
        <button type="submit"
          class="bg-[#7879E3] text-white px-5 py-2 rounded-md hover:bg-[#6566d4] focus:outline-none focus:ring-4 focus:ring-[#B1B3E0] transition-all"
        >
          Enregistrer
        </button>

        @if (session('status') === 'profile-updated')
          <p x-data="{ show: true }" x-show="show" x-transition
             x-init="setTimeout(() => show = false, 2500)"
             class="text-sm text-green-600">
            Modifications enregistrées.
          </p>
        @endif
      </div>
    </form>
  </div>
</section>
