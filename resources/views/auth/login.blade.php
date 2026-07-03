<x-layouts.app title="Connexion">
    <div class="min-h-screen flex flex-col justify-center items-center p-4 font-body">
        <form id="loginForm" 
            class="bg-base-green w-full max-w-4xl rounded-2xl sm:rounded-[32px] shadow-2xl p-6 sm:p-10 flex flex-col items-center relative">
            @csrf

            <div class="w-[100px] h-[100px] bg-cachou rounded-full flex items-center justify-center shadow-lg border-4 border-base-green mb-2">
                <a href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="47" viewBox="0 0 55 57" fill="#ffffff" class="h-10 w-10 text-white">
                        <g fill="currentColor" clip-path="url(#a)">
                            <path stroke="currentColor" stroke-miterlimit="10" stroke-width=".5" d="M22.78 22.08c-.19-.03-.34-.2-.23-.39l1.23-1.74-2.07-4.88c-1.65.59-3.45-.27-3.95-1.97l-1.11-5.39c-.02-.11.04-.21.14-.25l4.1-1.72c.16 0 .32.3.42.43.9 1.24 1.96 2.72 2.75 4.03.25.41.42.79.49 1.26.18 1.26-.53 2.59-1.7 3.11l2.1 4.9 2.09.3c.21.05.23.28.12.44l-4.37 1.86zm.74-.85 2.5-1.06-1.33-.2-.14-.13-2.25-5.28c-.1-.35.22-.35.45-.48 1.25-.7 1.69-2.19 1-3.45L20.81 6.3l-3.62 1.54 1.06 5.13c.42 1.38 1.81 2.09 3.18 1.67.25-.08.47-.31.65.01l2.24 5.28v.19l-.79 1.1z"/>
                            <path stroke="currentColor" stroke-miterlimit="10" stroke-width=".5" d="M20.79 7.35c.15-.11.3-.06.4.09.62 1.17 2.19 2.68 2.45 3.95.03.15.09.4-.06.49-.43.26-.41-.39-.48-.62-.05-.14-.12-.28-.18-.42l-2.19-3.2c-.05-.1-.03-.24.06-.3zM23.19 12.43c.16-.09.38.03.38.23 0 .05-.16.45-.19.49-.17.2-.46.11-.46-.16 0-.09.18-.5.27-.55z"/>
                            <path d="m23.13 20.28-4.96-3.95-4.21 1.08-.55-.03c-.29-.19-.3-.56 0-.74l3.8-1.01-3.77-2.94c-.75 0-3.9 1.21-4.37.89-.21-.15-.13-.61.12-.74.76-.42 2.41-.49 3.27-.85L8.58 9.31c-1.09.06-2.23.68-3.28.8-.43.05-.68.07-.74-.43l.19-.33 2.64-.8C6 7.85 3.38 6.26 1.81 6.72c-.55.16-.96.67-.97 1.25-.06 1.88 3.44 6.09 4.71 7.56.37.43 2.15 2.14 2.17 2.49.03.44-.43.58-.77.37-2.17-2.54-5.05-5.27-6.43-8.32-1.2-2.69-.35-4.72 2.85-4.22 2.53.4 7.12 3.54 9.29 5.09 4.06 2.9 7.85 6.19 11.79 9.24l.8.1c-.35-.81-.42-1.58-.15-2.43.11-.35.57-.99.57-1.22 0-.19-.48-1.05-.57-1.43-.21-.83-.23-1.44.08-2.25.11-.28.5-.77.5-.97 0-.18-.46-1-.55-1.35-.33-1.23-.19-2.15.52-3.2-1.43-2.49-.94-5.51 1.66-6.94 1.61-.89 4.39-.7 4.62 1.55.05.47-.11.89-.1 1.26.03.83.42 1.49.3 2.54-.06.47-.42 1.1-.41 1.49 0 .37.29 1.08.32 1.58.09 1.16-.32 2.02-.32 2.86 0 .66.53 1.61.32 2.38.65-.31 1.22-.74 1.9-1 1.45-.55 3.03-.63 4.53-.28l6.2-8.76c.44-.46.81-.47 1.35-.2s2.92 1.96 3.34 2.37c.35.35.46.79.21 1.24l-6.29 8.79c.65 1.22 1.22 2.54 1.13 3.96h7.34c.49.08.79.32.89.82l-.32 4.29c-.17.76-1.07.53-1.15.67L48.05 43c-.57 1.71-2.03 2.71-3.8 2.86H13.24c-1.84-.02-3.48-.99-4.09-2.77l-2.4-11.63c-.42-.4-1.28-.3-1.37-.98l-.74-9.29c.02-.33.45-.9.79-.9h17.71zM26.2 6.65c.16.14 1.06-.71 1.3-.87 1.25-.84 4.2-2.06 3.43-4.01C30.51.7 28.77.8 27.89 1.2c-2.13.99-2.59 3.42-1.69 5.45m4.96-2.22L28 6.5c-1.76 1.23-2.79 2.62-1.7 4.8.16.04.17-.04.26-.1.69-.48 1.86-1.47 2.48-2.06 1.33-1.25 2.45-2.78 2.11-4.71zm14.17.21-2.64 3.75 3.33 2.48 2.68-3.84-3.36-2.39zM26.3 15.95c.16.05.18-.05.26-.1 1.07-.72 3.14-2.43 3.8-3.5.78-1.28.92-2.54.69-4.01-.52.48-.95 1.05-1.48 1.53-1.86 1.7-4.92 2.99-3.28 6.08zm5.82 4.33h11.42c.03-1.5-.71-2.75-1.27-4.06l3.28-4.71-3.33-2.31-3.44 4.58c-1.16-.16-2.23-.34-3.4-.14-.97.17-2.79 1.01-3.4 1.78-.07.08-.79 1.85-.79 1.95 0 .18.45 1.05.55 1.34.17.51.27 1.04.39 1.56zm-1.17-7.29c-1.35 2.61-6.75 3.82-4.6 7.5 2.28-1.99 5.05-3.28 4.81-6.82 0-.14-.05-.64-.21-.69zm1.17 8.24c.01 1.47-.69 3.1-1.85 4.01-.28.22-.99.77-1.27.32-.35-.57.4-.74.69-1 1.88-1.66 1.97-4.29.79-6.4-.99 1.34-4.36 2.93-4.59 4.61-.04.29-.03.74 0 1.04.07.59.92 1.72.47 2.08l-.32.1c-.53-.05-1.08-1.99-1.11-2.49-.06-.88.25-1.57.74-2.27h-8.93l-4.86 11.95c-.06.07-.13.09-.22.11-.6.11-3.04-1.23-3.8-1.48l-.05.16 1.38 7.13h7.24c.59.12.46.95-.1.95H9.51c.2 2.09.56 4.45 3.02 4.85l31.81.02c1.23-.05 2.41-.89 2.79-2.07L50.2 26H35.35c-.33 0-.5-.66-.19-.85l16.14-.11.17-.25.21-3.54H32.12zm-16.5 0H5.58l.68 8.99 4.87 2.01z"/>
                            <path d="M22.97 34.98h10.68c.05 0 .28.27.27.38.06.14-.19.47-.27.47H22.97c-.05 0-.28-.27-.27-.38zM32.17 30.33h10.68c.28 0 .28.85 0 .85H32.17c-.05 0-.28-.27-.27-.38zM22.15 25.17c.39.39.05.77-.45.82-1.15.13-4.13.12-5.29 0-.79-.09-.79-.87 0-.95 1.25-.14 3.92-.11 5.19 0 .16.01.43.02.55.14zM43.59 39.1c.16.03.34.22.34.38 0 .21-.13.4-.32.49-.38.18-2.46.19-2.67-.24-.17-.17.08-.63.21-.63.68 0 1.82-.1 2.43 0z"/>
                        </g>
                    </svg>
                </a>
            </div>

            <div class="mb-8 mt-4 flex flex-col gap-2 w-full items-center">
                <h1 class="text-white text-center font-bold text-3xl sm:text-4xl italic tracking-wide">
                    Bienvenue
                </h1>

                <p class="text-sm text-white text-center mt-2 max-w-[280px]">
                    connectez-vous pour accéder à votre profil et gérer vos commandes
                </p>

            </div>

            <div id="errorMessages" class="hidden w-full bg-red-500/20 border border-red-500 text-white rounded-lg p-3 mb-6 text-sm leading-relaxed"></div>

            <div class="w-full flex flex-col gap-8">
                <div class="flex flex-col gap-1.5 w-full">
                    <span class="text-white ml-2 text-sm font-semibold tracking-wide">Adresse Email</span>
                    <x-icon-pill-input
                        type="email"
                        name="email"
                        required
                        placeholder="Email"
                        icon="images/mail.svg"
                        :asterisk="false"
                    />
                </div>

                <div class="flex flex-col gap-1.5 w-full">
                    <span class="text-white ml-2 text-sm font-semibold tracking-wide">Mot de passe</span>
                    <x-icon-pill-input
                        type="password"
                        name="password"
                        required
                        placeholder="Mot de passe"
                        icon="images/lock.svg"
                        :asterisk="false"
                    />
                </div>

                <div class="mt-4 flex justify-center w-full">
                    <x-pill-button type="submit" id="submitBtn">
                        <div class="flex items-center gap-2">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            Se connecter
                        </div>
                    </x-pill-button>
                </div>

                <div class="flex flex-col items-center w-full mt-4 gap-2">
                    <a href="{{ url('/auth/google/redirect') }}" class="px-6 sm:px-10 py-3 sm:py-4 text-gray-800 bg-white rounded-full hover:bg-gray-100 transition-all duration-200 text-xs sm:text-sm font-bold tracking-wide focus:outline-none cursor-pointer flex items-center gap-3 justify-center w-full sm:w-[85%] sm:max-w-[400px] mx-auto whitespace-nowrap shadow-md">
                        <img src="{{ asset('images/google-logo.svg') }}" alt="Google Logo" class="w-4 h-4 sm:w-5 sm:h-5">
                        Se connecter avec Google
                    </a>

                    <a href="/register" class="text-white text-sm hover:underline">
                        Pas de compte ? S'inscrire
                    </a>
                </div>
            </div>
        </form>
    </div>

    
</x-layouts.app>
