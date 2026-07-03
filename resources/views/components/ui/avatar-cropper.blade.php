@props(['inputId' => 'pdp_path', 'inputName' => 'pdp_path', 'alpineImage' => 'null', 'initialImage' => ''])

<div x-data="avatarCropper({ inputId: '{{ $inputId }}', inputName: '{{ $inputName }}', alpineImage: {{ $alpineImage }}, initialImage: '{{ $initialImage }}' })" x-init="initComponent()" class="relative flex justify-center w-full">

    <input type="file" :id="inputId" :name="inputName" accept="image/*" class="hidden">
    <input type="hidden" :name="'delete_' + inputName" :value="delete_pdp ? 1 : 0">

    <div x-show="showAvatarMenu" x-cloak class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center bg-black/50 backdrop-blur-sm p-4 sm:p-0" @click="showAvatarMenu = false">
        <div class="bg-white rounded-2xl w-full sm:w-96 shadow-2xl flex flex-col overflow-hidden transform transition-transform" @click.stop x-show="showAvatarMenu" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-lg text-gray-800">Modifier la photo</h3>
                <button type="button" @click="showAvatarMenu = false" class="text-gray-500 hover:text-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="flex flex-col p-2">
                <button type="button" @click="$refs.fileInputMenu.click(); showAvatarMenu = false" class="w-full flex items-center gap-3 px-4 py-4 hover:bg-gray-100 transition-colors text-left font-medium text-gray-700 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    Choisir une image (Galerie / Fichiers)
                </button>
                <input type="file" x-ref="fileInputMenu" accept="image/*" class="hidden" @change="handleFileChange">

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
                <button type="button" @click="captureWebcam" class="px-8 py-3 rounded-full font-bold text-white bg-base-green hover:bg-pine-green transition-colors shadow-md flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="3"></circle></svg>
                    Capturer
                </button>
            </div>
        </div>
    </div>

    <div x-show="showCropModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col" @click.stop>
            <div class="p-4 border-b flex justify-between items-center bg-gray-50 shrink-0">
                <h3 class="font-bold text-lg text-gray-800">Ajuster votre photo</h3>
                <button type="button" @click="closeCropModal" class="text-gray-500 hover:text-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="relative w-full flex-1 min-h-[40vh] sm:min-h-[500px] bg-gray-900 flex items-center justify-center overflow-hidden">
                <img id="cropperImageComponent" :src="cropImageUrl" class="max-w-full max-h-full block">
            </div>
            <div class="p-4 bg-gray-50 flex justify-end gap-3 border-t">
                <button type="button" @click="closeCropModal" class="px-6 py-2 rounded-full font-semibold text-gray-600 bg-gray-200 hover:bg-gray-300 transition-colors">Annuler</button>
                <button type="button" @click="confirmCrop" class="px-6 py-2 rounded-full font-semibold text-white bg-base-green hover:bg-pine-green transition-colors shadow-md flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    Valider
                </button>
            </div>
        </div>
    </div>

    <div class="relative flex items-center justify-center gap-4">
        <button type="button" @click="showAvatarMenu = true" class="w-[100px] h-[100px] bg-cachou rounded-full flex items-center justify-center shadow-lg border-4 border-base-green relative overflow-hidden group hover:border-info transition-colors focus:outline-none">
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
            </div>

            <template x-if="displayImage()">
                <img :src="displayImage()" class="w-full h-full object-cover" alt="Photo de profil">
            </template>
            <template x-if="!displayImage()">
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="47" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10 text-white">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </template>
        </button>

        <button type="button" x-show="displayImage()" @click="deleteProfilePicture" x-cloak class="absolute -right-4 bg-white p-2.5 rounded-full shadow-lg border-2 border-red-500 text-red-500 hover:bg-red-50 hover:text-red-600 transition-all focus:outline-none" title="Supprimer la photo">
            <img src="{{ asset('images/bin.svg') }}" alt="Supprimer" class="w-5 h-5" style="filter: invert(34%) sepia(87%) saturate(1915%) hue-rotate(338deg) brightness(98%) contrast(98%);">
        </button>
    </div>

    @once
    
    @endonce
</div>
