<script setup>
import { computed } from 'vue'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

const companyName = computed(() => {
    return props.offre?.entreprise?.user?.nom_complet || 'Company not specified'
})
const companyPhoto = computed(() => {
    return props.offre?.entreprise?.user?.photo || null
})
const companyInitials = computed(() => {
    const name = companyName.value
    if (!name || name === 'Company not specified') {
        return 'C'
    }
    return name
        .trim()
        .split(/\s+/)
        .slice(0, 2)
        .map(word => word.charAt(0).toUpperCase())
        .join('')
})
const location = computed(() => {
    return props.offre?.entreprise?.user?.ville?.nom || 'Location not specified'
})
const duration = computed(() => {
    return props.offre?.duree || 'Duration not specified'
})
const companyPhotoUrl = computed(() => {
    if (!companyPhoto.value) {
        return null
    }
    return companyPhoto.value.startsWith('http')
        ? companyPhoto.value
        : `/storage/${companyPhoto.value.replace(/^\/?storage\//, '')}`
})
</script>

<template>
    <section
        class="mb-5 rounded-2xl border border-slate-200 bg-white shadow-sm"
    >
        <div class="p-5 sm:p-6">
            <!-- Header -->
            <div
                class="flex items-start justify-between gap-4"
            >
                <div class="flex min-w-0 items-center gap-3">

                    <!-- Company logo / initials -->
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#E8F1F5] text-sm font-bold text-[#2F6690]"
                    >
                        <img
                            v-if="companyPhotoUrl"
                            :src="companyPhotoUrl"
                            :alt="companyName"
                            class="h-full w-full object-cover"
                        />
                        <span v-else>
                            {{ companyInitials }}
                        </span>
                    </div>

                    <!-- Offer information -->
                    <div class="min-w-0">
                        <p
                            class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#3A7CA5]"
                        >
                            Internship Application
                        </p>
                        <h1
                            class="mt-0.5 truncate text-lg font-bold leading-snug text-[#16425B] sm:text-xl"
                        >
                            {{ offre.titre }}
                        </h1>
                        <p class="mt-0.5 truncate text-xs font-medium text-slate-500">
                            {{ companyName }}
                        </p>
                    </div>
                </div>
                <!-- Application badge -->
                <span
                    class="hidden shrink-0 rounded-full bg-[#E8F1F5] px-2.5 py-1 text-[10px] font-semibold text-[#2F6690] sm:inline-flex"
                >
                    Application
                </span>
            </div>

            <!-- Details -->
            <div
                class="mt-5 grid grid-cols-1 gap-3 border-t border-slate-100 pt-4 sm:grid-cols-2"
            >
                <!-- Location -->
                <div
                    class="flex items-center gap-2.5 border-l-2 border-[#81C3D7] pl-3"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 shrink-0 text-[#2F6690]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 21s7-5.686 7-12A7 7 0 105 9c0 6.314 7 12 7 12z"
                        />
                        <circle
                            cx="12"
                            cy="9"
                            r="2.5"
                        />
                    </svg>

                    <div class="min-w-0">
                        <p class="text-[10px] font-medium uppercase tracking-wide text-slate-400">
                            Location
                        </p>

                        <p class="truncate text-xs font-semibold text-slate-700">
                            {{ location }}
                        </p>
                    </div>
                </div>

                <!-- Duration -->
                <div
                    class="flex items-center gap-2.5 border-l-2 border-[#81C3D7] pl-3"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 shrink-0 text-[#2F6690]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 7v5l3 2"
                        />
                    </svg>

                    <div class="min-w-0">
                        <p class="text-[10px] font-medium uppercase tracking-wide text-slate-400">
                            Duration
                        </p>

                        <p class="truncate text-xs font-semibold text-slate-700">
                            {{ duration }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>
