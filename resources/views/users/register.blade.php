<x-layouts.app title="Inscription">
    <div class="min-h-screen bg-[#dcdcdc] flex flex-col justify-center items-center p-4 font-sans">
        <form id="registerForm" enctype="multipart/form-data" 
            class="bg-[#057941] w-full max-w-[600px] rounded-[32px] shadow-[0_0_15px_rgba(93,176,229,0.4)] p-8 sm:p-10 flex flex-col items-center relative">
            @csrf

            <div class="mb-10 flex flex-col gap-2 w-full items-center">
                <h1 class="text-white text-center font-bold text-4xl tracking-wide">
                    Inscription
                </h1>
                
                <div class="h-px w-full max-w-sm bg-gradient-to-r from-transparent via-white to-transparent my-4"></div>

                <p class="text-sm text-white text-center">Les champs marqués d'un astérisque sont obligatoires à cette étape.</p>
            </div>

            <div id="errorMessages" class="hidden w-full bg-red-500/20 border border-red-500 text-white rounded-lg p-3 mb-6 text-sm leading-relaxed"></div>

            <div class="w-full flex flex-col gap-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                    <x-icon-pill-input
                        type="text"
                        name="firstname"
                        required
                        placeholder="Prénom"
                        icon="images/user.svg"
                        :asterisk="true"
                    />
                    <x-icon-pill-input
                        type="text"
                        name="lastname"
                        required
                        placeholder="Nom"
                        icon="images/user.svg"
                        :asterisk="true"
                    />
                </div>

                <x-icon-pill-input
                    type="text"
                    name="username"
                    required
                    placeholder="Nom d'utilisateur"
                    icon="images/user.svg"
                    :asterisk="true"
                />

                <x-icon-pill-input
                    type="email"
                    name="email"
                    required
                    placeholder="Email"
                    icon="images/mail.svg"
                    :asterisk="true"
                />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                    <x-icon-pill-input
                        type="password"
                        name="password"
                        required
                        placeholder="Mot de passe"
                        icon="images/lock.svg"
                        :asterisk="true"
                    />
                    <x-icon-pill-input
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="Confirmer"
                        icon="images/lock.svg"
                        :asterisk="true"
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
                    <x-pill-button type="submit" id="submitBtn">
                        Créer mon compte
                    </x-pill-button>
                </div>
                
                <div class="flex items-center w-full mt-2 mb-2">
                    <div class="flex-grow h-px bg-white/40"></div>
                    <span class="px-4 text-white text-sm font-light">OU</span>
                    <div class="flex-grow h-px bg-white/40"></div>
                </div>

                <div class="flex justify-center w-full">
                    <a href="/auth/google/redirect" class="flex items-center justify-center gap-3 w-full sm:w-2/3 bg-white text-gray-700 font-semibold py-3 px-6 rounded-full shadow-md hover:bg-gray-100 transition duration-300">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        S'inscrire avec Google
                    </a>
                </div>
                
            </div>

            <div class="mt-8">
                <a href="/login" class="text-white text-sm underline hover:text-sky-500">Déjà un compte ? Se connecter</a>
            </div>
        </form>
    </div>
</x-layouts.app>