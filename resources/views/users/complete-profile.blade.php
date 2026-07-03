<x-layouts.app title="Compléter le profil">
    <div class="min-h-screen flex flex-col justify-center items-center p-4 font-body">
        <form id="completeProfileForm" 
            class="bg-base-green w-full max-w-4xl rounded-[32px] shadow-2xl p-8 sm:p-10 flex flex-col items-center relative">
            @csrf

            <div class="mb-10 flex flex-col gap-2 w-full items-center">
                <h1 class="text-white text-center font-bold text-4xl tracking-wide">
                    Dernière étape
                </h1>

                <div class="h-px w-full max-w-sm bg-gradient-to-r from-transparent via-white to-transparent my-4"></div>

                <p class="text-sm text-white text-center">Veuillez vérifier vos informations et choisir un nom d'utilisateur pour terminer votre inscription.</p>
            </div>

            <div id="errorMessages" class="hidden w-full bg-red-500/20 border border-red-500 text-white rounded-lg p-3 mb-6 text-sm leading-relaxed"></div>

            <div class="w-full flex flex-col gap-8" id="formContent" style="display: none;">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 w-full">
                    <x-icon-pill-input
                        type="text"
                        name="firstname"
                        id="firstname"
                        required
                        placeholder="Prénom"
                        icon="images/user.svg"
                        :asterisk="true"
                    />
                    <x-icon-pill-input
                        type="text"
                        name="lastname"
                        id="lastname"
                        required
                        placeholder="Nom"
                        icon="images/user.svg"
                        :asterisk="true"
                    />
                </div>

                <x-icon-pill-input
                    type="email"
                    name="email"
                    id="email"
                    required
                    placeholder="Email"
                    icon="images/mail.svg"
                    :asterisk="true"
                />

                <x-icon-pill-input
                    type="text"
                    name="username"
                    id="username"
                    required
                    placeholder="Nom d'utilisateur"
                    icon="images/user.svg"
                    :asterisk="true"
                />

                <div class="mt-8 flex justify-center w-full">
                    <x-pill-button type="submit" id="submitBtn">
                        Valider mon profil
                    </x-pill-button>
                </div>
            </div>

            <div id="loading" class="text-white text-center w-full py-10">Chargement de vos informations...</div>
        </form>
    </div>

    
</x-layouts.app>
