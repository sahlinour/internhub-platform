<script setup>
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'

import ApplicationDetailsModal from './ApplicationDetailsModal.vue'

const props = defineProps({
    candidature: {
        type: Object,
        required: true,
    },
})

const showApplication = ref(false)
const offer = computed(() => props.candidature?.offre_de_stage)
const company = computed(() => offer.value?.entreprise)
const companyName = computed(
    () => company.value?.user?.nom_complet || 'Company'
)
const roleName = computed(
    () => offer.value?.titre || 'Internship'
)
const companyPhoto = computed(
    () => company.value?.user?.photo || null
)
const companyInitials = computed(() =>
    companyName.value
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map(word => word[0])
        .join('')
        .toUpperCase()
)
const appliedDate = computed(() =>
    props.candidature?.date_postulation
        ? new Date(props.candidature.date_postulation).toLocaleDateString(
              'en-US',
              {
                  month: 'short',
                  day: 'numeric',
                  year: 'numeric',
              }
          )
        : '-'
)
const statusClass = (status) => {
    switch (status) {
        case 'acceptee':
            return 'bg-emerald-50 text-emerald-700 border-emerald-100'

        case 'refusee':
            return 'bg-red-50 text-red-700 border-red-100'

        case 'en_cours_examen':
            return 'bg-[#E8F1F5] text-[#16425B] border-[#D5E5EC]'

        case 'en_attente':
        default:
            return 'bg-amber-50 text-[#B7791F] border-amber-100'
    }
}
const statusLabel = (status) => {
    switch (status) {
        case 'acceptee':
            return 'Accepted'

        case 'refusee':
            return 'Rejected'

        case 'en_cours_examen':
            return 'Under review'

        case 'en_attente':
            return 'Pending'

        default:
            return '-'
    }
}
const withdrawApplication = () => {
    if (!confirm('Are you sure you want to withdraw this application?')) {
        return
    }

    router.delete(
        route('stagiaire.candidatures.destroy', props.candidature.id),
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div
            class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6"
        >
            <!-- Company + application info -->
            <div class="flex min-w-0 items-center gap-4">
                <!-- Company logo / initials -->
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#E8F1F5] text-sm font-bold text-[#16425B]"
                >
                    <img
                        v-if="companyPhoto"
                        :src="companyPhoto"
                        :alt="companyName"
                        class="h-full w-full object-cover"
                    />
                    <span v-else>
                        {{ companyInitials }}
                    </span>
                </div>

                <!-- Information -->
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <h1
                            class="truncate text-base font-bold text-[#16425B] sm:text-lg"
                        >
                            {{ roleName }}
                        </h1>
                        <span
                            class="rounded-full border px-2 py-0.5 text-[10px] font-semibold"
                            :class="statusClass(candidature.statut)"
                        >
                            {{ statusLabel(candidature.statut) }}
                        </span>
                    </div>
                    <p
                        class="mt-0.5 truncate text-xs font-medium text-slate-600"
                    >
                        {{ companyName }}
                    </p>
                    <div
                        class="mt-1.5 flex items-center gap-1.5 text-[11px] text-slate-400"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-3.5 w-3.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>

                        Applied {{ appliedDate }}
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex shrink-0 gap-2 sm:ml-4">
                <!-- View Application -->
                <button
                    type="button"
                    @click="showApplication = true"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#16425B] px-3.5 py-2 text-[11px] font-semibold text-white transition hover:bg-[#2F6690]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        />
                    </svg>
                    View Application
                </button>

                <!-- Withdraw -->
                <button
                    v-if="candidature.statut === 'en_attente'"
                    type="button"
                    @click="withdrawApplication"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-3.5 py-2 text-[11px] font-semibold text-[#D80536] transition hover:bg-red-50"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m2 0v12a1 1 0 01-1 1H8a1 1 0 01-1-1V7h10z"
                        />
                    </svg>
                    Withdraw Application
                </button>
            </div>
        </div>
    </section>

    <!-- Application details modal -->
    <ApplicationDetailsModal
        :candidature="candidature"
        :show="showApplication"
        @close="showApplication = false"
    />
</template>