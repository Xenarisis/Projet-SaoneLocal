{{-- resources/views/pages/contact.blade.php --}}

<x-layouts.app title="Contact">
    <div class="max-w-2xl mx-auto px-4 py-8">

        <h1 class="font-bold text-2xl text-center rounded-2xl bg-base-green text-base-gray p-3 mb-6">
            Nous contacter
        </h1>

        <div class="flex flex-col gap-4">

            <section class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-bold text-lg mb-3"> Nous trouver</h2>
                <p>SaôneLocal</p>
                <p class="text-gray-600">Chalon-sur-Saône, 71100</p>
                <p class="text-gray-600">Bourgogne-Franche-Comté, France</p>
            </section>

            <section class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-bold text-lg mb-3"> Nous écrire</h2>
                <p class="text-gray-600">Pour toute question générale :</p>
                <a href="mailto:contact@saonelocal.fr" class="font-bold text-[#820606] underline">
                    contact@saonelocal.fr
                </a>
            </section>

            <section class="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-[#057941]">
                <h2 class="font-bold text-lg mb-3">🌱 Devenir producteur</h2>
                <p class="text-gray-600 mb-3">Vous êtes producteur local et souhaitez rejoindre notre réseau ? Nous serions ravis de vous accueillir sur la plateforme.</p>
                <p class="text-gray-600">Contactez-nous directement à :</p>
                <a href="mailto:producteurs@saonelocal.fr" class="font-bold text-[#057941] underline">
                    producteurs@saonelocal.fr
                </a>
                <p class="text-sm text-gray-500 mt-3">Nous vous répondrons dans les meilleurs délais avec toutes les informations nécessaires pour rejoindre SaôneLocal.</p>
            </section>

            <section class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-bold text-lg mb-3"> Horaires de disponibilité</h2>
                <p class="text-gray-600">Du lundi au vendredi</p>
                <p class="font-bold">9h00 — 18h00</p>
                <p class="text-sm text-gray-500 mt-2">Nous nous efforçons de répondre à toutes les demandes sous 48h ouvrées.</p>
            </section>

        </div>
    </div>
</x-layouts.app>