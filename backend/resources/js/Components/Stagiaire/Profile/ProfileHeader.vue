<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    stagiaire: {
        type: Object,
        required: true,
    },
})

const getPhotoUrl = (photo) => {
    if (!photo) {
        return null
    }

    if (photo.startsWith('http://') || photo.startsWith('https://')) {
        return photo
    }

    return `/storage/${photo}`
}

const formatStatus = (status) => {
    if (!status) {
        return 'Not specified'
    }

    const statuses = {
        en_recherche: 'Looking for an internship',
        en_stage: 'Currently in internship',
        termine: 'Internship completed',
    }

    return statuses[status] ?? status
}
</script>

<template>
    <section
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >
        <!-- Cover -->
        <div
            class="h-24 bg-gradient-to-r from-[#16425B] via-[#2F6690] to-[#3A7CA5]"
        ></div>

        <div class="px-5 pb-6 sm:px-7">
            <div class="-mt-10 flex flex-col gap-5 sm:flex-row sm:items-end">

                <!-- Profile photo -->
                <div
                    class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl border-4 border-white bg-[#E8F1F5] shadow-md"
                >
                    <img
                        v-if="getPhotoUrl(stagiaire.photo)"
                        :src="getPhotoUrl(stagiaire.photo)"
                        :alt="stagiaire.nom_complet"
                        class="h-full w-full object-cover"
                    />

                    <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-10 w-10 text-[#2F6690]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z"
                        />
                    </svg>
                </div>

                <!-- Identity -->
                <div class="min-w-0 flex-1">
                    <h2
                        class="truncate text-xl font-bold text-[#16425B]"
                    >
                        {{ stagiaire.nom_complet || 'Your Name' }}
                    </h2>

                    <p class="mt-1 truncate text-sm text-[#64748B]">
                        {{ stagiaire.email || 'No email provided' }}
                    </p>
                </div>

                <!-- Internship status -->
                <div
                    class="inline-flex w-fit items-center rounded-full bg-[#E8F1F5] px-3 py-1.5 text-xs font-semibold text-[#2F6690]"
                >
                    {{ formatStatus(stagiaire.stagiaire?.statut_stage) }}
                </div>
            </div>
        </div>
    </section>
</template>