<x-layouts.app title="a propos">
    <div class="w-full h-full place-content-center text-center">
        <h1 class="border rounded-full m-2 p-2 bg-[#057941] text-[#DEDEDE]">Notre histoire</h1>
        <p class="font-bold pb-3">Votre territoire, vos producteurs, votre plateforme</p>
        <p class="pb-1">SaôneLocal est une association regroupant une cinquantaine de producteurs locaux du bassin chalonnais</p>
        <p class="font-bold pb-2"> — vignerons, maraîchers, apiculteurs, fromagers.— </p>
        <img src="{{ asset('images/producers.jpg') }}" alt="À propos" class="w-full h-64 lg:h-96 object-cover rounded-2xl mb-4">
        <p>SaôneLocal est axé sur les produits frais de saisons,des rencontres avec les  producteurs se font réguliérement prêt de chez vous.</p>
    </div>
    <div class="w-full h-full place-content-center text-center">
        <h1 class="border rounded-full m-2 p-2 bg-[#057941] text-[#DEDEDE]">Nos valeurs</h1>
        <div class="flex flex-wrap gap-2 justify-center font-bold">
            <p class="border rounded-2xl bg-[#057941] text-[#DEDEDE] p-2">Proximité & Lien humain</p>
            <p class="border rounded-2xl bg-[#057941] text-[#DEDEDE] p-2">Terroir & Authenticité</p>
            <p class="border rounded-2xl bg-[#057941] text-[#DEDEDE] p-2">Confiance</p>
            <p class="border rounded-2xl bg-[#057941] text-[#DEDEDE] p-2">Savoir-faire</p>
            <p class="border rounded-2xl bg-[#057941] text-[#DEDEDE] p-2">Solidarité</p>
        </div>
    </div>
</x-layouts.app>