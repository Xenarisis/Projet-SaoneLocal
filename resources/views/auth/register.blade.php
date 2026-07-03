<x-layouts.app title="Inscription">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    
    @php
        $isProducer = request('role') === 'producer';
    @endphp

    <div class="min-h-screen flex flex-col justify-center items-center p-4 font-body mt-20">
        <form id="registerForm" enctype="multipart/form-data" 
            class="bg-base-green w-full max-w-4xl rounded-2xl sm:rounded-[32px] shadow-2xl p-6 sm:p-10 flex flex-col items-center relative">
            @csrf
            <input type="hidden" name="role" value="{{ $isProducer ? 'producer' : 'user' }}">

            <div class="mb-10 flex flex-col gap-2 w-full items-center">
                <div class="w-full flex justify-center mb-2">
                    @if(!$isProducer)
                        <a href="{{ route('users.register', ['role' => 'producer']) }}" class="flex items-center gap-2 text-white/90 font-bold text-sm hover:text-white transition-all border-2 border-white/60 hover:border-white rounded-full px-5 py-2 shadow-sm hover:bg-white/10">
                            <x-icon name="logo" class="w-5 h-5" />
                            Vous êtes producteur ? Créer un compte pro
                        </a>
                    @else
                        <a href="{{ route('users.register') }}" class="flex items-center gap-2 text-white/90 font-bold text-sm hover:text-white transition-all border-2 border-white/60 hover:border-white rounded-full px-5 py-2 shadow-sm hover:bg-white/10">
                            <x-icon name="user" class="w-5 h-5" />
                            S'inscrire en tant qu'utilisateur
                        </a>
                    @endif
                </div>

                <h1 class="text-white text-center font-bold text-3xl sm:text-4xl tracking-wide">
                    {{ $isProducer ? 'Inscription Producteur' : 'Inscription' }}
                </h1>

                <div class="h-px w-full max-w-sm bg-gradient-to-r from-transparent via-white to-transparent my-4"></div>

                <p class="text-sm text-white text-center">Les champs marqués d'un astérisque sont obligatoires à cette étape.</p>
            </div>

            <div id="errorMessages" class="hidden w-full bg-red-500/20 border border-red-500 text-white rounded-lg p-3 mb-6 text-sm leading-relaxed"></div>

            <div class="w-full flex flex-col gap-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 w-full">
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Prénom</span>
                        <x-icon-pill-input
                            type="text"
                            name="firstname"
                            required
                            placeholder="Prénom"
                            icon="images/user.svg"
                            :asterisk="true"
                        />
                    </div>
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Nom</span>
                        <x-icon-pill-input
                            type="text"
                            name="lastname"
                            required
                            placeholder="Nom"
                            icon="images/user.svg"
                            :asterisk="true"
                        />
                    </div>
                </div>

                <div class="flex flex-col gap-1.5 w-full">
                    <span class="text-white ml-2 text-sm font-semibold tracking-wide">Nom d'utilisateur</span>
                    <x-icon-pill-input
                        type="text"
                        name="username"
                        required
                        placeholder="Nom d'utilisateur"
                        icon="images/user.svg"
                        value="User_{{ \Illuminate\Support\Str::random(5) }}"
                        :asterisk="true"
                    />
                </div>

                <div class="flex flex-col gap-1.5 w-full">
                    <span class="text-white ml-2 text-sm font-semibold tracking-wide">Adresse Email</span>
                    <x-icon-pill-input
                        type="email"
                        name="email"
                        required
                        placeholder="Email"
                        icon="images/mail.svg"
                        :asterisk="true"
                    />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 w-full">
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Mot de passe</span>
                        <x-icon-pill-input
                            type="password"
                            name="password"
                            required
                            placeholder="Mot de passe"
                            icon="images/lock.svg"
                            :asterisk="true"
                        />
                        <span class="text-white/70 ml-3 text-xs italic">Entre 6 et 50 caractères.</span>
                    </div>
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Confirmer le mot de passe</span>
                        <x-icon-pill-input
                            type="password"
                            name="password_confirmation"
                            required
                            placeholder="Confirmer"
                            icon="images/lock.svg"
                            :asterisk="true"
                        />
                    </div>
                </div>

                @if($isProducer)
                    <div class="w-full flex items-center mt-6 mb-2">
                        <div class="flex-grow h-px bg-white/40"></div>
                        <span class="px-4 text-white text-lg font-bold tracking-wide">Informations de l'organisation</span>
                        <div class="flex-grow h-px bg-white/40"></div>
                    </div>

                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Nom de l'organisation</span>
                        <x-icon-pill-input
                            type="text"
                            name="producer_name"
                            required
                            placeholder="Nom de l'entreprise ou de l'exploitation"
                            icon="images/user.svg"
                            :asterisk="true"
                        />
                    </div>

                    <div class="flex flex-col gap-1.5 w-full mt-4">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Présentation (optionnelle)</span>
                        <x-icon-pill-input
                            type="text"
                            name="presentation"
                            placeholder="Courte description de votre activité"
                            icon="images/user.svg"
                            :asterisk="false"
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 w-full mt-4">
                        <div class="flex flex-col gap-1.5 w-full">
                            <span class="text-white ml-2 text-sm font-semibold tracking-wide">Adresse (ligne 1)</span>
                            <x-icon-pill-input
                                type="text"
                                name="street_line_1"
                                required
                                placeholder="Numéro et nom de rue"
                                icon="images/user.svg"
                                :asterisk="true"
                            />
                        </div>
                        <div class="flex flex-col gap-1.5 w-full">
                            <span class="text-white ml-2 text-sm font-semibold tracking-wide">Complément d'adresse</span>
                            <x-icon-pill-input
                                type="text"
                                name="street_line_2"
                                placeholder="Bâtiment, lieu-dit..."
                                icon="images/user.svg"
                                :asterisk="false"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 w-full mt-4 mb-6">
                        <div class="flex flex-col gap-1.5 w-full">
                            <span class="text-white ml-2 text-sm font-semibold tracking-wide">Code postal</span>
                            <x-icon-pill-input
                                type="text"
                                name="postal_code"
                                required
                                placeholder="Ex: 71100"
                                icon="images/user.svg"
                                :asterisk="true"
                            />
                        </div>
                        <div class="flex flex-col gap-1.5 w-full">
                            <span class="text-white ml-2 text-sm font-semibold tracking-wide">Ville</span>
                            <x-icon-pill-input
                                type="text"
                                name="city"
                                required
                                placeholder="Chalon-sur-Saône"
                                icon="images/user.svg"
                                :asterisk="true"
                            />
                        </div>
                    </div>
                @endif

                <div class="flex justify-center w-full mt-2">
                    <div class="w-full sm:w-2/3 flex flex-col gap-1.5">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide text-center">Photo de profil (optionnel)</span>
                        <x-avatar-cropper inputId="pdp_path" inputName="pdp" />
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

                <a href="{{ url('/auth/google/redirect') }}" class="px-6 sm:px-10 py-3 sm:py-4 text-gray-800 bg-white rounded-full hover:bg-gray-100 transition-all duration-200 text-xs sm:text-sm font-bold tracking-wide focus:outline-none cursor-pointer flex items-center gap-3 justify-center w-full sm:w-[85%] sm:max-w-[320px] mx-auto shadow-md">
                    <img src="{{ asset('images/google-logo.svg') }}" alt="Google Logo" class="w-4 h-4 sm:w-5 sm:h-5">
                    S'inscrire avec Google
                </a>
            </div>

            <div class="mt-8 flex flex-col items-center gap-3">
                <a href="/login" class="text-white text-sm underline hover:text-sky-500">Déjà un compte ? Se connecter</a>
            </div>
        </form>
    </div>
</x-layouts.app>