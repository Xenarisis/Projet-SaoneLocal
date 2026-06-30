<div
    x-data="{ 
        show: false,
        title: '',
        description: '',
        type: 'success',
        color: '',
        icon: '',
        setStyle(t) {
            if(t === 'error') { 
                this.color = 'bg-red-500 dark:bg-red-400'; 
                this.icon = '{{ asset('images/notif/error.svg') }}'; 
            }
            else if(t === 'info') { 
                this.color = 'bg-blue-500 dark:bg-blue-400'; 
                this.icon = '{{ asset('images/notif/info.svg') }}'; 
            }
            else if(t === 'warning') { 
                this.color = 'bg-amber-500 dark:bg-amber-400'; 
                this.icon = '{{ asset('images/notif/warn.svg') }}'; 
            }
            else { 
                this.color = 'bg-green-500 dark:bg-green-400'; 
                this.icon = '{{ asset('images/notif/check.svg') }}'; 
            }
        }
    }"
    x-init="
        const flashNotif = sessionStorage.getItem('flash_notification');
        if (flashNotif) {
            const data = JSON.parse(flashNotif);
            title = data.title;
            description = data.description;
            type = data.type || 'success';
            sessionStorage.removeItem('flash_notification');
            setTimeout(() => {
                setStyle(type);
                show = true;
                setTimeout(() => show = false, 5000);
            }, 100);
        } else {
            setStyle(type);
            if(title !== '') { show = true; setTimeout(() => show = false, 5000); }
        }
    "
    @notify.window="
        title = $event.detail.title;
        description = $event.detail.description;
        type = $event.detail.type || 'success';
        setStyle(type);
        show = true;
        setTimeout(() => show = false, 5000);
    "
    x-cloak
    x-show="show" 
    x-transition:enter="transition ease-out duration-300" 
    x-transition:enter-start="opacity-0 transform translate-x-4" 
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform translate-x-4"
    {{ $attributes->merge(['class' => 'fixed top-4 left-4 right-4 sm:left-auto sm:right-4 sm:w-full sm:max-w-sm z-50 flex items-start p-4 gap-3 bg-white border border-slate-200 rounded-lg shadow-lg dark:bg-slate-800 dark:border-slate-700']) }}
>
    <div class="flex-shrink-0">
        <div 
            class="w-8 h-8" 
            :class="color"
            :style="`mask-image: url('${icon}'); -webkit-mask-image: url('${icon}'); mask-size: contain; -webkit-mask-size: contain; mask-repeat: no-repeat; -webkit-mask-repeat: no-repeat; mask-position: center; -webkit-mask-position: center;`"
            aria-label="Notification icon"
            role="img"
        ></div>
    </div>

    <div class="flex flex-col flex-1">
        <span class="text-base font-semibold text-slate-800 dark:text-white" x-text="title"></span>
        <span class="text-sm text-slate-500 mt-0.5 dark:text-slate-400" x-html="description"></span>
    </div>

    <div class="flex-shrink-0 ml-2">
        <button 
            @click="show = false" 
            type="button" 
            class="text-slate-400 transition-colors hover:text-slate-600 dark:hover:text-slate-200 focus:outline-none" 
            aria-label="Fermer la notification"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>