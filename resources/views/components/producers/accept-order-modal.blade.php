<div x-cloak x-show="showAcceptModal" class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div @click.away="showAcceptModal = false" class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden" x-transition.opacity>
        <div class="bg-cachou p-6 text-white">
            <h3 class="text-2xl font-bold">Traiter la commande</h3>
            <p class="text-sm text-gray-200 mt-1" x-text="modalOrder ? modalOrder.quantity + 'x ' + modalOrder.product_name : ''"></p>
        </div>
        <div class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de retrait</label>
                <input type="date" x-model="modalOrder.pickup_date" @click="$el.showPicker()" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 cursor-pointer focus:ring-cachou focus:border-cachou">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lieu de retrait</label>
                <input type="text" x-model="modalOrder.pickup_location" placeholder="Ex: Marché de Chalon, À la ferme..." class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-cachou focus:border-cachou">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heure de retrait</label>
                <input type="time" x-model="modalOrder.pickup_time" @click="$el.showPicker()" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 cursor-pointer focus:ring-cachou focus:border-cachou">
            </div>
        </div>
        <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-4">
            <button @click="showAcceptModal = false" class="px-5 py-2 text-gray-600 font-medium hover:bg-gray-200 rounded-lg transition-colors cursor-pointer">Fermer</button>
            <button @click="updateOrderItem(modalOrder.id, 'annulée')" class="px-5 py-2 bg-red-100 text-red-700 font-bold rounded-lg hover:bg-red-200 transition-colors cursor-pointer">Refuser</button>
            <button @click="updateOrderItem(modalOrder.id, 'en préparation', modalOrder.pickup_location, modalOrder.pickup_date, modalOrder.pickup_time)" class="px-5 py-2 bg-cachou text-white font-bold rounded-lg hover:opacity-90 cursor-pointer transition-opacity">Accepter</button>
        </div>
    </div>
</div>
