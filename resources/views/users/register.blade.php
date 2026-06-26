<x-layouts.app title="Inscription">
    <div class="min-h-screen bg-[#dcdcdc] flex flex-col justify-center items-center p-4 font-sans">
        <form method="POST" action="/register" enctype="multipart/form-data" 
            class="bg-[#057941] w-full max-w-[600px] rounded-[32px] shadow-[0_0_15px_rgba(93,176,229,0.4)] p-8 sm:p-10 flex flex-col items-center relative">
            @csrf

            <h1 class="text-white font-bold text-3xl mb-8 tracking-wide">
                Inscription
            </h1>

            <div class="w-full flex flex-col gap-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                    <x-icon-pill-input
                        type="text"
                        name="firstname"
                        required
                        placeholder="Prénom"
                        icon="images/user.svg"
                    />
                    <x-icon-pill-input
                        type="text"
                        name="lastname"
                        required
                        placeholder="Nom"
                        icon="images/user.svg"
                    />
                </div>

                <x-icon-pill-input
                    type="text"
                    name="username"
                    required
                    placeholder="Nom d'utilisateur"
                    icon="images/user.svg"
                />

                <x-icon-pill-input
                    type="email"
                    name="email"
                    required
                    placeholder="Email"
                    icon="images/mail.svg"
                />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                    <x-icon-pill-input
                        type="password"
                        name="password"
                        required
                        placeholder="Mot de passe"
                        icon="images/lock.svg"
                    />
                    <x-icon-pill-input
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="Confirmer"
                        icon="images/lock.svg"
                    />
                </div>

                <div class="flex justify-center w-full mt-2">
                    <div class="w-full sm:w-2/3">
                        <x-icon-pill-input
                            type="file"
                            id="pdp_path"
                            name="pdp_path"
                            accept="image/*"
                            placeholder="Photo de profil"
                            icon="images/camera.svg"
                        />
                    </div>
                </div>

                <div class="mt-8 flex justify-center w-full">
                    <x-pill-button type="submit">
                        Créer mon compte
                    </x-pill-button>
                </div>
                
            </div>

            <div class="mt-8">
                <a href="/login" class="text-white text-sm hover:underline">Déjà un compte ? Se connecter</a>
            </div>
        </form>
    </div>
</x-layouts.app>