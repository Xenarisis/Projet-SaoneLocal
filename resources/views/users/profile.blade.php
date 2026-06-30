<x-layouts.app title="Mon Profil">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <div class="min-h-screen bg-[#dcdcdc] flex flex-col justify-center items-center p-4 font-sans pt-24 pb-12" x-data="profileData()" x-init="init()">

        <div x-show="showCropModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col" @click.stop>
                <div class="p-4 border-b flex justify-between items-center bg-gray-50 shrink-0">
                    <h3 class="font-bold text-lg text-gray-800">Ajuster votre photo</h3>
                    <button type="button" @click="closeCropModal" class="text-gray-500 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="relative w-full flex-1 min-h-[40vh] sm:min-h-[500px] bg-gray-900 flex items-center justify-center overflow-hidden">
                    <img id="cropperImage" :src="cropImageUrl" class="max-w-full max-h-full block">
                </div>
                <div class="p-4 bg-gray-50 flex justify-end gap-3 border-t">
                    <button type="button" @click="closeCropModal" class="px-6 py-2 rounded-full font-semibold text-gray-600 bg-gray-200 hover:bg-gray-300 transition-colors">Annuler</button>
                    <button type="button" @click="confirmCrop" class="px-6 py-2 rounded-full font-semibold text-white bg-[#057941] hover:bg-[#046134] transition-colors shadow-md flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Valider
                    </button>
                </div>
            </div>
        </div>

        <div x-show="showAvatarMenu" x-cloak class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center bg-black/50 backdrop-blur-sm p-4 sm:p-0" @click="showAvatarMenu = false">
            <div class="bg-white rounded-2xl w-full sm:w-96 shadow-2xl flex flex-col overflow-hidden transform transition-transform" @click.stop x-show="showAvatarMenu" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-800">Modifier la photo</h3>
                    <button type="button" @click="showAvatarMenu = false" class="text-gray-500 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="flex flex-col p-2">
                    <button type="button" @click="$refs.fileInput.click(); showAvatarMenu = false" class="w-full flex items-center gap-3 px-4 py-4 hover:bg-gray-100 transition-colors text-left font-medium text-gray-700 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        Choisir une image (Galerie / Fichiers)
                    </button>
                    <button type="button" @click="openWebcam" class="w-full flex items-center gap-3 px-4 py-4 hover:bg-gray-100 transition-colors text-left font-medium text-gray-700 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        Prendre une photo (Webcam)
                    </button>
                </div>
            </div>
        </div>

        <div x-show="showWebcamModal" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4" @click="closeWebcam">
            <div class="bg-white rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl flex flex-col" @click.stop>
                <div class="p-4 border-b flex justify-between items-center bg-gray-50 shrink-0">
                    <h3 class="font-bold text-lg text-gray-800">Prendre une photo</h3>
                    <button type="button" @click="closeWebcam" class="text-gray-500 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="relative w-full bg-black flex items-center justify-center overflow-hidden min-h-[300px] sm:min-h-[400px]">
                    <video x-ref="webcamVideo" class="w-full h-full object-contain" autoplay playsinline></video>
                </div>
                <div class="p-4 bg-gray-50 flex justify-center border-t">
                    <button type="button" @click="captureWebcam" class="px-8 py-3 rounded-full font-bold text-white bg-[#057941] hover:bg-[#046134] transition-colors shadow-md flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="3"></circle></svg>
                        Capturer
                    </button>
                </div>
            </div>
        </div>

        <div x-show="loading" class="flex justify-center items-center w-full max-w-[700px] h-[400px]">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-t-2 border-[#057941]"></div>
        </div>

        <form @submit.prevent="saveProfile" @input="debouncedSave" x-show="!loading && user" style="display: none;" 
             class="bg-[#057941] w-full max-w-[700px] rounded-2xl sm:rounded-[32px] shadow-[0_0_15px_rgba(93,176,229,0.4)] p-6 sm:p-10 flex flex-col items-center relative mt-10">

            <div class="absolute -top-12 flex items-center justify-center gap-4">

                <button type="button" @click="showAvatarMenu = true" class="w-[100px] h-[100px] bg-[#2E0B0B] rounded-full flex items-center justify-center shadow-lg border-4 border-[#057941] relative overflow-hidden group hover:border-[#5db0e5] transition-colors focus:outline-none">
                    <input type="file" x-ref="fileInput" accept="image/*" class="hidden" @change="handleFileChange">

                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                    </div>

                    <template x-if="pdpPreview || user?.pdp">
                        <img :src="pdpPreview || user?.pdp" class="w-full h-full object-cover" alt="Photo de profil">
                    </template>
                    <template x-if="!(pdpPreview || user?.pdp)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="47" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10 text-white">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </template>
                </button>

                <button type="button" x-show="pdpPreview || user?.pdp" @click="deleteProfilePicture" x-cloak class="absolute -right-14 bg-white p-2.5 rounded-full shadow-lg border-2 border-red-500 text-red-500 hover:bg-red-50 hover:text-red-600 transition-all focus:outline-none" title="Supprimer la photo">
                    <img src="{{ asset('images/bin.svg') }}" alt="Supprimer" class="w-5 h-5" style="filter: invert(34%) sepia(87%) saturate(1915%) hue-rotate(338deg) brightness(98%) contrast(98%);">
                </button>
            </div>

            <div class="mb-8 mt-12 flex flex-col gap-2 w-full items-center">
                <h1 class="text-white text-center font-bold text-3xl sm:text-4xl italic tracking-wide" x-text="`${editForm.firstname || ''} ${editForm.lastname || ''}`.trim() || 'Mon Profil'"></h1>
                <p class="text-white/80 text-center font-medium mt-1" x-text="editForm.username ? `@${editForm.username}` : ''"></p>
                <div class="flex gap-3 mt-4 flex-wrap justify-center">
                    <span class="bg-[#046134] text-white/90 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span x-text="user?.role === 'user' ? 'Utilisateur' : user?.role"></span>
                    </span>
                    <span class="bg-[#046134] text-white/90 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm flex items-center gap-1" x-show="user?.created_at">
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
                            :asterisk="false"
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
                            :asterisk="false"
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
                        :asterisk="false"
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
                        :asterisk="false"
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
                        <button type="button" @click="deleteAccount" class="px-8 py-4 bg-red-600 text-white rounded-full font-bold hover:bg-red-700 transition-colors duration-200 shadow-md flex items-center justify-center gap-3 w-full sm:w-auto flex-1 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            Supprimer le compte
                        </button>

                        <button type="button" @click="linkGoogle" x-show="user && !user.has_google_linked" class="px-8 py-4 bg-white text-gray-800 rounded-full font-bold hover:bg-gray-100 transition-colors duration-200 shadow-md flex items-center justify-center gap-3 w-full sm:w-auto flex-1 whitespace-nowrap" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                                <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                                <path fill="#FF3D00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"/>
                                <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                                <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                            </svg>
                            Associer à Google
                        </button>

                        <button type="button" @click="linkGoogle" x-show="user && user.has_google_linked" class="px-8 py-4 bg-white text-gray-800 rounded-full font-bold hover:bg-gray-100 shadow-md flex items-center justify-center gap-3 w-full sm:w-auto flex-1 whitespace-nowrap transition-colors duration-200" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                                <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                                <path fill="#FF3D00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"/>
                                <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                                <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                            </svg>
                            Changer le compte Google
                        </button>

                        <a href="{{ route('logout.page') }}" class="px-8 py-4 bg-[#2E0B0B] text-white rounded-full font-bold hover:bg-[#1a0606] transition-colors duration-200 shadow-md flex items-center justify-center gap-3 w-full sm:w-auto flex-1 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            Déconnexion
                        </a>
                    </div>
                </div>

            </div>
        </form>

        <div x-show="!loading && !user && fetchError" class="bg-[#057941] w-full max-w-[700px] rounded-2xl sm:rounded-[32px] shadow-[0_0_15px_rgba(93,176,229,0.4)] p-6 sm:p-10 flex flex-col items-center relative mt-10 text-center" style="display: none;">
            <div class="w-16 h-16 bg-[#2E0B0B] text-red-400 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <h2 class="text-2xl font-bold text-white mb-2 italic">Erreur de chargement</h2>
            <p class="text-white/80 mb-8" x-text="fetchError"></p>
            <a href="{{ route('users.login') }}" class="px-8 py-4 bg-[#2E0B0B] text-white rounded-full font-bold hover:bg-[#1a0606] transition-colors inline-block shadow-md">Retour à la connexion</a>
        </div>
    </div>

    <script>
        function profileData() {
            return {
                user: null,
                loading: true,
                saving: false,
                fetchError: null,
                error: null,
                successMessage: null,
                editForm: {
                    firstname: '',
                    lastname: '',
                    username: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                pdpFile: null,
                pdpPreview: null,
                saveTimeout: null,
                lastSaved: null,
                showCropModal: false,
                cropImageUrl: null,
                cropper: null,
                showAvatarMenu: false,
                showWebcamModal: false,
                webcamStream: null,
                delete_pdp: false,
                linkGoogle() {
                    const token = localStorage.getItem('jwt_token');
                    window.location.href = `/auth/google/redirect?token=${token}`;
                },
                deleteProfilePicture() {
                    if (confirm("Voulez-vous vraiment supprimer votre photo de profil ?")) {
                        this.pdpPreview = null;
                        this.pdpFile = null;
                        this.delete_pdp = true;

                        if (this.user) {
                            this.user.pdp = null;
                        }

                        this.debouncedSave();
                    }
                },
                async openWebcam() {
                    this.showAvatarMenu = false;
                    try {
                        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                            alert("La webcam n'est pas supportée sur ce navigateur ou cette connexion. Si vous n'êtes pas sur localhost, une connexion sécurisée (HTTPS) est requise.");
                            return;
                        }
                        this.webcamStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                        this.showWebcamModal = true;
                        this.$nextTick(() => {
                            this.$refs.webcamVideo.srcObject = this.webcamStream;
                        });
                    } catch (err) {
                        console.error("Erreur d'accès à la webcam", err);
                        alert("Impossible d'accéder à la webcam. Veuillez vérifier que vous avez une webcam branchée et que vous avez accordé les permissions au navigateur.");
                    }
                },
                closeWebcam() {
                    this.showWebcamModal = false;
                    if (this.webcamStream) {
                        this.webcamStream.getTracks().forEach(track => track.stop());
                        this.webcamStream = null;
                    }
                    if (this.$refs.webcamVideo) {
                        this.$refs.webcamVideo.srcObject = null;
                    }
                },
                captureWebcam() {
                    const video = this.$refs.webcamVideo;
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const ctx = canvas.getContext('2d');

                    ctx.translate(canvas.width, 0);
                    ctx.scale(-1, 1);
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                    this.cropImageUrl = canvas.toDataURL('image/jpeg', 1.0);

                    this.closeWebcam();

                    this.showCropModal = true;
                    this.$nextTick(() => {
                        const image = document.getElementById('cropperImage');
                        if (this.cropper) {
                            this.cropper.destroy();
                        }
                        this.cropper = new Cropper(image, {
                            aspectRatio: 1,
                            viewMode: 1,
                            dragMode: 'move',
                            autoCropArea: 1,
                            restore: false,
                            guides: true,
                            center: true,
                            highlight: false,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                            toggleDragModeOnDblclick: false,
                        });
                    });
                },
                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.cropImageUrl = URL.createObjectURL(file);
                        this.showCropModal = true;

                        this.$nextTick(() => {
                            const image = document.getElementById('cropperImage');
                            image.onload = () => {
                                if (this.cropper) {
                                    this.cropper.destroy();
                                }
                                this.cropper = new Cropper(image, {
                                    aspectRatio: 1,
                                    viewMode: 1,
                                    dragMode: 'move',
                                    autoCropArea: 1,
                                    restore: false,
                                    guides: true,
                                    center: true,
                                    highlight: false,
                                    cropBoxMovable: true,
                                    cropBoxResizable: true,
                                    toggleDragModeOnDblclick: false,
                                });
                            };
                        });

                        event.target.value = '';
                    }
                },
                closeCropModal() {
                    this.showCropModal = false;
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }
                    this.cropImageUrl = null;
                },
                confirmCrop() {
                    if (!this.cropper) return;

                    this.cropper.getCroppedCanvas({
                        width: 400,
                        height: 400
                    }).toBlob((blob) => {
                        const file = new File([blob], "avatar.jpg", { type: "image/jpeg" });
                        this.pdpFile = file;
                        this.pdpPreview = URL.createObjectURL(blob);

                        this.closeCropModal();
                        this.debouncedSave();
                    }, 'image/jpeg', 0.9);
                },
                debouncedSave() {
                    if (this.saveTimeout) clearTimeout(this.saveTimeout);
                    this.saveTimeout = setTimeout(() => {
                        this.saveProfile();
                    }, 1000);
                },
                async init() {
                    const token = localStorage.getItem('jwt_token');
                    if (!token) {
                        window.location.href = '/login';
                        return;
                    }

                    try {
                        const res = await fetch('/api/users/me', {
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Accept': 'application/json'
                            }
                        });

                        if (res.ok) {
                            const json = await res.json();
                            this.user = json.data || json;
                            this.editForm = {
                                firstname: this.user.firstname || '',
                                lastname: this.user.lastname || '',
                                username: this.user.username || '',
                                email: this.user.email || '',
                                password: '',
                                password_confirmation: ''
                            };
                        } else {
                            localStorage.removeItem('jwt_token');
                            window.location.href = '/login';
                        }
                    } catch (e) {
                        console.error('Erreur', e);
                        this.fetchError = 'Impossible de charger vos données. Veuillez vérifier votre connexion.';
                    } finally {
                        this.loading = false;
                    }
                },
                async deleteAccount() {
                    if (!confirm("Êtes-vous sûr de vouloir supprimer définitivement votre compte ? Cette action est irréversible.")) {
                        return;
                    }

                    try {
                        const token = localStorage.getItem('jwt_token');
                        const res = await fetch(`/api/users/${this.user.id}`, {
                            method: 'DELETE',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Accept': 'application/json'
                            }
                        });

                        if (res.ok) {
                            localStorage.removeItem('jwt_token');
                            sessionStorage.setItem('flash_notification', JSON.stringify({
                                title: 'Compte supprimé',
                                description: 'Votre compte a été définitivement supprimé.',
                                type: 'info'
                            }));
                            window.location.href = '/login';
                        } else {
                            const data = await res.json();
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    title: 'Erreur',
                                    description: data.message || 'Impossible de supprimer le compte.',
                                    type: 'error'
                                }
                            }));
                        }
                    } catch (e) {
                        console.error(e);
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                title: 'Erreur réseau',
                                description: 'Impossible de joindre le serveur.',
                                type: 'error'
                            }
                        }));
                    }
                },
                async saveProfile() {
                    this.saving = true;

                    try {
                        const formData = new FormData();
                        formData.append('_method', 'PUT');
                        formData.append('firstname', this.editForm.firstname);
                        formData.append('lastname', this.editForm.lastname);
                        formData.append('username', this.editForm.username);
                        formData.append('email', this.editForm.email);
                        if (this.editForm.password) {
                            formData.append('password', this.editForm.password);
                            formData.append('password_confirmation', this.editForm.password_confirmation);
                        }
                        if (this.pdpFile) {
                            formData.append('pdp', this.pdpFile);
                        }
                        if (this.delete_pdp) {
                            formData.append('delete_pdp', 1);
                        }

                        const token = localStorage.getItem('jwt_token');
                        const res = await fetch(`/api/users/${this.user.id}`, {
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await res.json();

                        if (res.ok) {
                            this.user = data.data || { ...this.user, ...this.editForm, pdp: this.pdpPreview || this.user.pdp };
                            this.pdpFile = null;
                            this.delete_pdp = false;
                            this.lastSaved = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    title: 'Profil mis à jour',
                                    description: data.message || 'Vos informations ont été mises à jour avec succès !',
                                    type: 'success'
                                }
                            }));
                        } else {
                            let errorMsg = data.message || 'Une erreur est survenue lors de la mise à jour.';
                            if (data.errors) {
                                errorMsg = Object.values(data.errors).map(msg => msg.join(', ')).join('<br>');
                            }
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    title: 'Erreur',
                                    description: errorMsg,
                                    type: 'error'
                                }
                            }));
                        }
                    } catch (e) {
                        console.error(e);
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                title: 'Erreur réseau',
                                description: 'Impossible de joindre le serveur.',
                                type: 'error'
                            }
                        }));
                    } finally {
                        this.saving = false;
                    }
                }
            }
        }
    </script>
</x-layouts.app>
