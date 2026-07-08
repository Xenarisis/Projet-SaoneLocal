<x-layouts.app title="Mon Profil">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    

    <div class="min-h-screen flex flex-col justify-center items-center p-4 font-body pt-24 pb-12" x-data="profileData()" x-init="init()">

        

        

        

        <div x-show="loading" class="flex justify-center items-center w-full max-w-[700px] h-[400px]">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-t-2 border-base-green"></div>
        </div>

        <div x-show="!loading && user" x-cloak class="w-full max-w-[1000px] flex flex-col items-center">
            
            <!-- Tab navigation removed -->

            <form @submit.prevent="saveProfile" @input="debouncedSave" 
                 class="bg-base-green w-full max-w-[700px] rounded-2xl sm:rounded-[32px] shadow-2xl p-6 sm:p-10 flex flex-col items-center relative mt-10">

            <div class="absolute -top-12 flex items-center justify-center gap-4 w-full">
                <x-avatar-cropper alpineImage="user?.pdp" @avatar-changed="saveAvatar" @avatar-deleted="saveAvatar" />
            </div>

            <div class="mb-8 mt-12 flex flex-col gap-2 w-full items-center">
                <h1 class="text-white text-center font-bold text-3xl sm:text-4xl italic tracking-wide" x-text="`${editForm.firstname || ''} ${editForm.lastname || ''}`.trim() || 'Mon Profil'"></h1>
                <p class="text-white/80 text-center font-medium mt-1" x-text="editForm.username ? `@${editForm.username}` : ''"></p>
                <div class="flex gap-3 mt-4 flex-wrap justify-center">
                    <span class="bg-pine-green text-white/90 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span x-text="user?.role === 'user' ? 'Utilisateur' : (user?.role === 'producer' ? 'Producteur' : user?.role)"></span>
                    </span>
                    <span class="bg-pine-green text-white/90 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm flex items-center gap-1" x-show="user?.created_at">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span x-text="'Membre depuis le ' + new Date(user?.created_at).toLocaleDateString('fr-FR')"></span>
                    </span>
                </div>
            </div>

            <div class="w-full flex flex-col gap-5">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 w-full">
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Prénom</span>
                        <x-icon-pill-input
                            type="text"
                            name="firstname"
                            x-model="editForm.firstname"
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
                            x-model="editForm.lastname"
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
                        x-model="editForm.username"
                        required
                        placeholder="Nom d'utilisateur"
                        icon="images/user.svg"
                        :asterisk="true"
                    />
                </div>

                <div class="flex flex-col gap-1.5 w-full">
                    <span class="text-white ml-2 text-sm font-semibold tracking-wide">Adresse Email</span>
                    <x-icon-pill-input
                        type="email"
                        name="email"
                        x-model="editForm.email"
                        required
                        placeholder="Email"
                        icon="images/mail.svg"
                        :asterisk="true"
                    />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 w-full">
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Mot de passe</span>
                        <x-icon-pill-input
                            type="password"
                            name="password"
                            x-model="editForm.password"
                            placeholder="Vide pour ne pas changer"
                            icon="images/lock.svg"
                            :asterisk="false"
                        />
                        <span class="text-white/70 ml-3 text-xs italic">Entre 6 et 50 caractères.</span>
                    </div>
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Confirmer le mot de passe</span>
                        <x-icon-pill-input
                            type="password"
                            name="password_confirmation"
                            x-model="editForm.password_confirmation"
                            placeholder="Confirmer le nouveau"
                            icon="images/lock.svg"
                            :asterisk="false"
                        />
                    </div>
                </div>

                <template x-if="user?.role === 'producer'">
                    <div class="w-full flex flex-col gap-5 mt-8">
                        <div class="w-full flex items-center mb-2">
                            <div class="flex-grow h-px bg-white/40"></div>
                            <span class="px-4 text-white text-lg font-bold tracking-wide">Informations de l'organisation</span>
                            <div class="flex-grow h-px bg-white/40"></div>
                        </div>

                        <div class="flex flex-col gap-1.5 w-full">
                            <span class="text-white ml-2 text-sm font-semibold tracking-wide">Nom de l'organisation</span>
                            <x-icon-pill-input
                                type="text"
                                name="producer_name"
                                x-model="editForm.producer_name"
                                required
                                placeholder="Nom de l'entreprise ou de l'exploitation"
                                icon="images/user.svg"
                                :asterisk="true"
                            />
                        </div>

                        <div class="flex flex-col gap-1.5 w-full">
                            <span class="text-white ml-2 text-sm font-semibold tracking-wide">Présentation</span>
                            <x-icon-pill-input
                                type="text"
                                name="presentation"
                                x-model="editForm.presentation"
                                placeholder="Courte description de votre activité"
                                icon="images/user.svg"
                                :asterisk="false"
                            />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 w-full">
                            <div class="flex flex-col gap-1.5 w-full">
                                <span class="text-white ml-2 text-sm font-semibold tracking-wide">Adresse (ligne 1)</span>
                                <x-icon-pill-input
                                    type="text"
                                    name="street_line_1"
                                    x-model="editForm.street_line_1"
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
                                    x-model="editForm.street_line_2"
                                    placeholder="Bâtiment, lieu-dit..."
                                    icon="images/user.svg"
                                    :asterisk="false"
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 w-full mb-4">
                            <div class="flex flex-col gap-1.5 w-full">
                                <span class="text-white ml-2 text-sm font-semibold tracking-wide">Code postal</span>
                                <x-icon-pill-input
                                    type="text"
                                    name="postal_code"
                                    x-model="editForm.postal_code"
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
                                    x-model="editForm.city"
                                    required
                                    placeholder="Chalon-sur-Saône"
                                    icon="images/user.svg"
                                    :asterisk="true"
                                />
                            </div>
                        </div>
                    </div>
                </template>

                <div class="mt-8 flex flex-col items-center gap-4 w-full">
                    <div class="flex items-center gap-2 text-white/90 text-sm font-medium w-full sm:w-auto">
                        <template x-if="saving">
                            <div class="flex items-center gap-2">
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-t-2 border-white"></div>
                                Enregistrement automatique...
                            </div>
                        </template>
                        <template x-if="!saving && lastSaved">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                <span x-text="'Enregistré à ' + lastSaved"></span>
                            </div>
                        </template>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between w-full mt-4 gap-4 flex-wrap">
                        <button type="button" @click="deleteAccount" class="px-8 py-4 bg-red-600 text-white rounded-full font-bold hover:bg-red-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-3 w-full sm:w-auto flex-1 whitespace-nowrap cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            Supprimer le compte
                        </button>

                        <button type="button" @click="linkGoogle" x-show="user && !user.has_google_linked" class="px-8 py-4 bg-white text-gray-800 rounded-full font-bold hover:bg-gray-100 transition-colors duration-200 shadow-md flex items-center justify-center gap-3 w-full sm:w-auto flex-1 whitespace-nowrap cursor-pointer" x-cloak>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                                <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                                <path fill="#FF3D00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"/>
                                <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                                <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                            </svg>
                            Associer à Google
                        </button>

                        <button type="button" @click="linkGoogle" x-show="user && user.has_google_linked" class="px-8 py-4 bg-white text-gray-800 rounded-full font-bold hover:bg-gray-100 shadow-md flex items-center justify-center gap-3 w-full sm:w-auto flex-1 whitespace-nowrap transition-colors duration-200 cursor-pointer" x-cloak>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                                <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                                <path fill="#FF3D00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"/>
                                <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                                <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                            </svg>
                            Changer le compte Google
                        </button>

                        <button type="button" @click="becomeProducer" x-show="user && user.role === 'user'" class="px-8 py-4 bg-yellow-500 text-white rounded-full font-bold hover:bg-yellow-600 transition-colors duration-200 shadow-md flex items-center justify-center gap-3 w-full sm:w-auto flex-1 whitespace-nowrap cursor-pointer" x-cloak>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            Devenir producteur
                        </button>

                        <button type="button" @click="stopProducer" x-show="user && user.role === 'producer'" class="px-8 py-4 bg-red-500 text-white rounded-full font-bold hover:bg-red-600 transition-colors duration-200 shadow-md flex items-center justify-center gap-3 w-full sm:w-auto flex-1 whitespace-nowrap cursor-pointer" x-cloak>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg>
                            Ne plus être producteur
                        </button>

                        <a href="{{ route('logout.page') }}" class="px-8 py-4 bg-cachou text-white rounded-full font-bold hover:bg-dark transition-colors duration-200 shadow-md flex items-center justify-center gap-3 w-full sm:w-auto flex-1 whitespace-nowrap cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            Déconnexion
                        </a>
                    </div>
                </div>

            </div>
        </form>

            <!-- Favorites section moved to favorites.blade.php -->

        </div>

        <div x-show="!loading && !user && fetchError" class="bg-base-green w-full max-w-[700px] rounded-2xl sm:rounded-[32px] shadow-2xl p-6 sm:p-10 flex flex-col items-center relative mt-10 text-center" x-cloak>
            <div class="w-16 h-16 bg-cachou text-red-400 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <h2 class="text-2xl font-bold text-white mb-2 italic">Erreur de chargement</h2>
            <p class="text-white/80 mb-8" x-text="fetchError"></p>
            <a href="{{ route('users.login') }}" class="px-8 py-4 bg-cachou text-white rounded-full font-bold hover:bg-dark transition-colors inline-block shadow-md">Retour à la connexion</a>
        </div>
    </div>

    
</x-layouts.app>
