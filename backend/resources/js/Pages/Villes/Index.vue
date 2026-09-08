<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
    offres: {
        type: Object, // Inertia pagination returns an object with a 'data' array
        default: () => ({ data: [] }),
    },
    filters: {
        type: Object,
        default: () => ({ search: '', duree: '' }),
    },
})

// Local reactive search input initialized from URL props
const search = ref(props.filters.search || '')

// Handle real-time search filtering
const handleSearch = () => {
    router.get(
        route('guest.offres.index'),
        { search: search.value },
        { preserveState: true, replace: true }
    )
}
</script>

<template>
    <div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- Page Header & Guest Notice -->
            <div class="mb-8 text-center sm:text-left sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Offres de Stage Disponibles</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Explorez nos opportunités de stage. Connectez-vous en tant que stagiaire pour postuler.
                    </p>
                </div>
                
                <!-- Quick Auth Buttons for Guests -->
                <div class="mt-4 sm:mt-0 flex justify-center gap-3">
                    <Link
                        :href="route('login')"
                        class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition"
                    >
                        Se Connecter
                    </Link>
                    <Link
                        :href="route('register')"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition"
                    >
                        S'inscrire
                    </Link>
                </div>
            </div>

            <!-- Search Bar Filter -->
            <div class="mb-8 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="relative">
                    <input
                        v-model="search"
                        @input="handleSearch"
                        type="text"
                        placeholder="Rechercher par titre de stage..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    />
                    <svg
                        class="w-5 h-5 text-gray-400 absolute left-3 top-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Offers Grid -->
            <div v-if="offres.data && offres.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="offre in offres.data"
                    :key="offre.id"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition flex flex-col justify-between"
                >
                    <div class="p-6">
                        <!-- Header: Company & City -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">
                                {{ offre.duree }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ offre.entreprise?.user?.ville?.nom || 'Ville non spécifiée' }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h2 class="text-lg font-bold text-gray-900 line-clamp-1 mb-2">
                            {{ offre.titre }}
                        </h2>

                        <!-- Company Name -->
                        <p class="text-sm font-medium text-gray-700 mb-3">
                            🏢 {{ offre.entreprise?.user?.nom_complet || 'Entreprise' }}
                        </p>

                        <!-- Description preview -->
                        <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                            {{ offre.description }}
                        </p>
                    </div>

                    <!-- Footer Action -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-xl flex items-center justify-between">
                        <span class="text-xs text-gray-500">
                            Limite: {{ new Date(offre.date_limite).toLocaleDateString('fr-FR') }}
                        </span>

                        <!-- Login to Apply Prompt -->
                        <Link
                            :href="route('login')"
                            class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800"
                        >
                            Connectez-vous pour postuler &rarr;
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
                <p class="text-base text-gray-500 font-medium">Aucune offre de stage active disponible pour le moment.</p>
            </div>

            <!-- Debug Info (Optional) -->
            <div class="mt-10 p-4 bg-gray-800 text-green-400 rounded-lg text-xs font-mono overflow-auto">
                <p class="font-bold text-white mb-2">Raw Props Data Debug:</p>
                <pre>{{ offres }}</pre>
            </div>

        </div>
    </div>
</template>