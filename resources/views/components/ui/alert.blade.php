<div x-data="{
        show: false,
        title: '',
        message: '',
        type: 'alert', // 'alert' ou 'confirm'
        onConfirmCallback: null,
        
        openAlert(event) {
            this.title = event.detail.title || 'Information';
            this.message = event.detail.message || '';
            this.type = event.detail.type || 'alert';
            this.onConfirmCallback = event.detail.onConfirm || null;
            this.show = true;
        },
        
        confirm() {
            this.show = false;
            if (this.onConfirmCallback) {
                this.onConfirmCallback();
            }
        },
        
        cancel() {
            this.show = false;
        }
    }"
    @open-alert.window="openAlert($event)"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div class="bg-white rounded-2xl w-full max-w-sm shadow-2xl flex flex-col overflow-hidden transform transition-transform"
        @click.stop
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div class="p-4 border-b flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-lg text-gray-800" x-text="title"></h3>
            <button type="button" @click="cancel" class="text-gray-500 hover:text-red-500 transition-colors focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="p-6 text-gray-700 font-medium whitespace-pre-line text-center" x-text="message"></div>
        
        <div class="p-4 bg-gray-50 flex justify-end gap-3 border-t">
            <button x-show="type === 'confirm'" type="button" @click="cancel" class="px-6 py-2 rounded-full font-semibold text-gray-600 bg-gray-200 hover:bg-gray-300 transition-colors focus:outline-none">
                Annuler
            </button>
            <button type="button" @click="confirm" class="px-6 py-2 rounded-full font-semibold text-white transition-colors shadow-md flex items-center gap-2 focus:outline-none"
                    :class="type === 'confirm' ? 'bg-red-600 hover:bg-red-700' : 'bg-base-green hover:bg-pine-green'">
                <span x-text="type === 'confirm' ? 'Confirmer' : 'OK'"></span>
            </button>
        </div>
    </div>
</div>
