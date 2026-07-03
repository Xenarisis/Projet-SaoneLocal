{{-- resources/views/pages/calendar.blade.php --}}

<x-layouts.app title="Calendrier">

<div class="w-screen rounded-3xl overflow-hidden"">
        <!-- Composant Calendrier -->
        <div x-data="calendar()" x-init="" class="w-full bg-base-green/20 rounded-lg shadow-lg overflow-hidden border border-chrome-green/30">
            
            <!-- En-tête : Navigation -->
            <div class="flex items-center justify-between p-4 bg-chrome-green text-base-gray">
                <button @click="changeMonth(-1)" class="hover:bg-base-green hover:text-chrome-green px-4 py-2 rounded transition font-bold">&lt; Préc</button>
                <h2 class="text-xl font-bold capitalize" x-text="monthName + ' ' + year"></h2>
                <button @click="changeMonth(1)" class="hover:bg-base-green hover:text-chrome-green px-4 py-2 rounded transition font-bold">Suiv &gt;</button>
            </div>

            <!-- Jours de la semaine -->
            <div class="grid grid-cols-7 text-center bg-base-green text-chrome-green font-bold py-3">
                <template x-for="day in weekDays" :key="day">
                    <div x-text="day"></div>
                </template>
            </div>

            <!-- Grille des dates -->
            <div class="grid grid-cols-7 auto-rows-fr bg-chrome-green/20 gap-px border-b border-chrome-green/30">
                
                <!-- Cases vides (mois précédent) -->
                <template x-for="i in blankDays" :key="'blank-'+i">
                    <div class="h-32 bg-base-green/10"></div>
                </template>

                <!-- Jours du mois -->
                <template x-for="day in daysInMonth" :key="day">
                    <div class="h-32 bg-base-green/5 p-2 relative hover:bg-base-green/30 transition flex flex-col rounded-2xl m-1 border border-transparent hover:border-chrome-green/50">
                        
                        <!-- Numéro du jour + Bouton + -->
                        <div class="flex justify-between items-start mb-1">
                            <span class="font-bold text-lg leading-none"
                                  :class="{'text-red-blood bg-red-100 rounded-full w-8 h-8 flex items-center justify-center shadow-sm': isToday(day), 'text-chrome-green dark:text-base-gray': !isToday(day)}" 
                                  x-text="day">
                            </span>
                            
                            <button @click="selectDate(day)" class="text-chrome-green/40 dark:text-base-gray hover:text-chrome-green font-bold text-xl leading-none transition" title="Ajouter un événement">
                                +
                            </button>
                        </div>

                        <!-- Liste des événements -->
                        <div class="flex-1 w-full overflow-y-auto space-y-1 custom-scrollbar">
                            <template x-for="event in getEventsForDay(day)" :key="event.id">
                                <div class="text-xs bg-chrome-green text-base-gray p-1.5 rounded-md shadow-sm cursor-pointer hover:brightness-110 transition truncate font-medium"
                                     :title="event.event_name + ' • ' + event.city">
                                    <span x-text="event.event_name"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        
        <!-- Feedback de sélection -->
        <div class="mt-6 p-4 bg-white rounded-xl shadow border-l-4 border-chrome-green flex items-center justify-between" x-show="selectedDate" x-transition>
            <div>
                <span class="block text-sm text-gray-500 font-bold uppercase">Date sélectionnée</span>
                <span class="text-xl font-bold text-chrome-green" x-text="selectedDate"></span>
            </div>
            <button @click="selectedDate = null" class="text-gray-400 hover:text-red-500 font-bold">&times;</button>
        </div>
    </div>

    <!-- Récupère toute les informations  -->
    <script>
        function calendar() {
            return {
                events: [],
                year: new Date().getFullYear(),
                month: new Date().getMonth(),
                selectedDate: null,
                weekDays: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                selectedEvent: null,
                openModal: false,
                
                get monthName() {
                    return this.monthNames[this.month];
                },

                get blankDays() {
                    return new Date(this.year, this.month, 1).getDay();
                },

                get daysInMonth() {
                    return new Date(this.year, this.month + 1, 0).getDate();
                },

                isToday(day) {
                    const today = new Date();
                    return day === today.getDate() && 
                        this.month === today.getMonth() && 
                        this.year === today.getFullYear();
                },

                // Récupération des événements via API
                fetchEvents() {
                    const monthStr = (this.month + 1).toString().padStart(2, '0');
                    // On demande les événements du mois en cours
                    const url = `/api/events?event_date=${this.year}-${monthStr}`; 
                    


                    fetch(url)
                        .then(response => {
                            if (!response.ok) throw new Error('Erreur réseau');
                            return response.json();
                        })
                        .then(data => {
                            // Votre EventResource::collection retourne { data: [...], links: {...}, meta: {...} }
                            this.events = data.data || [];

                        })
                        .catch(err => console.error("Erreur chargement:", err));
                },

                // Filtrage des événements pour un jour donné
                getEventsForDay(day) {
                    const currentMonthStr = (this.month + 1).toString().padStart(2, '0');
                    const currentDayStr = day.toString().padStart(2, '0');
                    const dateStr = `${this.year}-${currentMonthStr}-${currentDayStr}`;

                    // Le filtrage utilise .startsWith() pour兼容 le format ISO "2026-07-15T..."
                    return this.events.filter(e => {
                        return e.event_date && e.event_date.startsWith(dateStr);
                    });
                },

                selectDate(day) {
                    const m = (this.month + 1).toString().padStart(2, '0');
                    const d = day.toString().padStart(2, '0');
                    this.selectedDate = `${this.year}-${m}-${d}`;
                    
                    // Exemple d'action future :
                    // window.location.href = `/events/create?date=${this.selectedDate}`;
                },

                changeMonth(offset) {
                    this.month += offset;
                    if (this.month > 11) {
                        this.month = 0;
                        this.year++;
                    } else if (this.month < 0) {
                        this.month = 11;
                        this.year--;
                    }
                    this.fetchEvents(); // Recharge les données pour le nouveau mois
                },

                // Ouvre le Modal
                openEventModal(event) {
                    this.selectedEvent = event;
                    this.openModal = true;
                },

                // Ferme le Modal
                closeEventModal() {
                    this.openModal = false;
                    setTimeout(() => this.selectedEvent = null, 300);
                }
            }
        }
    </script>
    
    <style>
        /* Style optionnel pour la barre de défilement des événements */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #166534;
            border-radius: 20px;
        }
    </style>

    <!-- Overlay / Modale -->
    <div x-show="openModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
        @click.self="closeEventModal()" 
        x-cloak>

        <!-- Contenu de la modale -->
        <div x-show="openModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-4"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-chrome-green/20"
            @click.stop>
            
            <!-- En-tête de la modale -->
            <div class="bg-chrome-green p-4 flex justify-between items-start">
                <h3 class="text-xl font-bold text-base-gray" x-text="selectedEvent?.event_name"></h3>
                <button @click="closeEventModal()" class="text-base-gray hover:text-white transition font-bold text-xl">&times;</button>
            </div>

            <!-- Corps de la modale -->
            <div class="p-6 space-y-4">
                <!-- Date -->
                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-chrome-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="font-medium" x-text="selectedEvent?.event_date"></span>
                </div>

                <!-- Ville -->
                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-chrome-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="font-medium">
                        <span x-text="selectedEvent?.city"></span>
                        <span x-show="selectedEvent?.postal_code" class="text-gray-400 ml-1" x-text="'(' + selectedEvent?.postal_code + ')'"></span>
                    </span>
                </div>

                <!-- Adresse complète -->
                <div class="flex items-start text-gray-600">
                    <svg class="w-5 h-5 mr-2 mt-1 text-chrome-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <div>
                        <p x-text="selectedEvent?.street_line_1"></p>
                        <p x-show="selectedEvent?.street_line_2" x-text="selectedEvent?.street_line_2"></p>
                        <p x-show="selectedEvent?.postal_code && selectedEvent?.city" x-text="selectedEvent?.postal_code + ' ' + selectedEvent?.city" class="font-bold text-gray-800 mt-1"></p>
                    </div>
                </div>

                <!-- Description -->
                <div x-show="selectedEvent?.description" class="mt-4 pt-4 border-t border-gray-100">
                    <h4 class="font-bold text-chrome-green mb-1">Description</h4>
                    <p class="text-gray-600 text-sm leading-relaxed" x-text="selectedEvent?.description"></p>
                </div>
            </div>

            <!-- Pied de page (Actions) -->
            <div class="bg-gray-50 p-4 flex justify-end gap-2">
                <button @click="closeEventModal()" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-200 transition font-medium">Fermer</button>
                <!-- Vous pouvez ajouter un bouton "Modifier" ici -->
            </div>
        </div>
    </div>   

</x-layouts.app>