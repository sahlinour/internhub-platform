<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
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

const getInitials = (name) => {
    if (!name) {
        return 'U'
    }

    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map(word => word[0])
        .join('')
        .toUpperCase()
}

const formatStatus = (status) => {
    if (!status) {
        return 'Not specified'
    }

    const statuses = {
        recherche: 'Looking for an internship',
        en_attente: 'Application pending',
        en_cours: 'Currently in internship',
        termine: 'Internship completed',
        annule: 'Cancelled',
    }

    return statuses[status] ?? status
}
</script>

<template>
    <section
        class="overflow-hidden rounded-2xl bg-gradient-to-r from-[#16425B] via-[#2F6690] to-[#3A7CA5] shadow-sm"
    >
        <div class="px-5 py-6 sm:px-7">
            <div
                class="flex flex-col gap-6 sm:flex-row sm:items-center"
            >
                <!-- Profile photo -->
                <div
                    class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl border-4 border-white/80 bg-white/20 shadow-md"
                >
                    <img
                        v-if="getPhotoUrl(stagiaire.photo)"
                        :src="getPhotoUrl(stagiaire.photo)"
                        :alt="stagiaire.nom_complet || 'Profile photo'"
                        class="h-full w-full object-cover"
                    />

                    <span
                        v-else
                        class="text-2xl font-bold text-white"
                    >
                        {{ getInitials(stagiaire.nom_complet) }}
                    </span>
                </div>

                <!-- Identity -->
                <div class="min-w-0 flex-1">
                    <h2
                        class="truncate text-xl font-bold text-white sm:text-2xl"
                    >
                        {{ stagiaire.nom_complet || 'Your Name' }}
                    </h2>

                    <p
                        class="mt-1 truncate text-sm text-white/80"
                    >
                        {{ stagiaire.email || 'No email provided' }}
                    </p>

                    <!-- Academic information -->
                    <div
                        v-if="
                            stagiaire.stagiaire?.filiere ||
                            stagiaire.stagiaire?.niveau
                        "
                        class="mt-2 flex flex-wrap items-center gap-2 text-xs text-white/70"
                    >
                        <span
                            v-if="stagiaire.stagiaire?.filiere"
                            class="font-medium text-white/90"
                        >
                            {{ stagiaire.stagiaire.filiere }}
                        </span>

                        <span
                            v-if="
                                stagiaire.stagiaire?.filiere &&
                                stagiaire.stagiaire?.niveau
                            "
                            class="text-white/40"
                        >
                            •
                        </span>

                        <span
                            v-if="stagiaire.stagiaire?.niveau"
                        >
                            {{ stagiaire.stagiaire.niveau }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div
                    class="flex flex-col items-start gap-3 sm:items-end"
                >
                    <!-- Internship status -->
                    <span
                        class="inline-flex w-fit items-center rounded-full bg-white/15 px-3 py-1.5 text-xs font-semibold text-white ring-1 ring-white/20"
                    >
                        <span
                            class="mr-2 h-1.5 w-1.5 rounded-full bg-[#81C3D7]"
                        ></span>

                        {{ formatStatus(stagiaire.stagiaire?.statut_stage) }}
                    </span>

                    <!-- Edit profile -->
                    <Link
                        :href="route('stagiaire.profile.edit')"
                        class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-xs font-semibold text-[#16425B] shadow-sm transition duration-200 hover:bg-[#E8F1F5]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13l-3.2.96.96-3.2a4.5 4.5 0 011.13-1.897L16.862 4.487z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 7.5L16.5 4.5"
                            />
                        </svg>

                        Edit Profile
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>