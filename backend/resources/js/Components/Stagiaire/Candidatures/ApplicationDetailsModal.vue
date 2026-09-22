<script setup>
import { computed } from 'vue'

const props = defineProps({
    candidature: {
        type: Object,
        required: true,
    },

    show: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['close'])
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
const offer = computed(() => props.candidature?.offre_de_stage)
const roleName = computed(
    () => offer.value?.titre || 'Internship'
)
const companyName = computed(
    () => offer.value?.entreprise?.user?.nom_complet || 'Company'
)
const appliedDate = computed(() => {
    if (!props.candidature?.date_postulation) return '-'
    return new Date(
        props.candidature.date_postulation
    ).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    })
})
const hasCoverLetter = computed(
    () => !!props.candidature?.lettre_de_motivation
)
const hasCv = computed(
    () => !!props.candidature?.cv_url
)
</script>

<template>
    <Teleport to="body">
        <div
            v-if="show"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 px-4 py-6"
            @click.self="emit('close')"
        >
            <div
                class="w-full max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl"
            >
                <!-- Header -->
                <div
                    class="flex items-center justify-between border-b border-slate-100 px-5 py-4"
                >
                    <div class="min-w-0">
                        <p
                            class="text-[10px] font-semibold uppercase tracking-wider text-[#3A7CA5]"
                        >
                            Application
                        </p>

                        <h2
                            class="mt-0.5 truncate text-base font-bold text-[#16425B]"
                        >
                            {{ roleName }}
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            {{ companyName }}
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="emit('close')"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-[#16425B]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="max-h-[70vh] overflow-y-auto px-5 py-5">
                    <!-- Application info -->
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-xl bg-[#F4F7F9] px-4 py-3">
                            <p class="text-[10px] font-medium text-slate-400">
                                Applied
                            </p>

                            <p class="mt-1 text-xs font-semibold text-[#16425B]">
                                {{ appliedDate }}
                            </p>
                        </div>
                        <div class="rounded-xl bg-[#F4F7F9] px-4 py-3">
                            <p class="text-[10px] font-medium text-slate-400">
                                Status
                            </p>

                            <p class="mt-1 text-xs font-semibold text-[#16425B]">
                                {{ statusLabel(candidature.statut) }}
                            </p>
                        </div>
                    </div>

                    <!-- Cover Letter -->
                    <div class="mt-5">
                        <div class="mb-2 flex items-center gap-2">
                            <div
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#16425B]"
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
                                        d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M14 2v6h6M8 13h8M8 17h5"
                                    />
                                </svg>
                            </div>

                            <h3 class="text-xs font-bold text-[#16425B]">
                                Cover Letter
                            </h3>
                        </div>

                        <div
                            class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3"
                        >
                            <p
                                v-if="hasCoverLetter"
                                class="whitespace-pre-line text-xs leading-5 text-slate-600"
                            >
                                {{ candidature.lettre_de_motivation }}
                            </p>

                            <p
                                v-else
                                class="text-xs italic text-slate-400"
                            >
                                No cover letter provided.
                            </p>
                        </div>
                    </div>

                <!-- CV -->
                <div class="mt-5">
                    <div class="mb-2 flex items-center gap-2">
                        <!-- icon -->
                        <h3 class="text-xs font-bold text-[#16425B]">
                            Curriculum Vitae
                        </h3>
                    </div>

                    <div
                        v-if="hasCv"
                        class="flex items-center justify-between rounded-xl border border-slate-200 bg-white px-4 py-3 transition hover:border-[#81C3D7] hover:bg-[#F4F7F9]"
                    >
                        <div class="flex min-w-0 items-center gap-3">
                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#16425B]"
                            >
                                <span class="text-[10px] font-bold">
                                    CV
                                </span>
                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-xs font-semibold text-[#16425B]">
                                    {{
                                        candidature.cv_url
                                            .split('/')
                                            .pop()
                                    }}
                                </p>

                                <p class="text-[10px] text-slate-400">
                                    Curriculum Vitae
                                </p>
                            </div>
                        </div>

                        <a
                            :href="candidature.cv_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="ml-3 shrink-0 text-[11px] font-semibold text-[#3A7CA5] transition hover:text-[#16425B]"
                        >
                            View →
                        </a>
                    </div>

                    <div
                        v-else
                        class="rounded-xl bg-slate-50 px-4 py-3"
                    >
                        <p class="text-xs italic text-slate-400">
                            No CV provided.
                        </p>
                    </div>
                </div>
                </div>

                <!-- Footer -->
                <div
                    class="flex justify-end border-t border-slate-100 px-5 py-3"
                >
                    <button
                        type="button"
                        @click="emit('close')"
                        class="rounded-lg bg-[#16425B] px-4 py-2 text-[11px] font-semibold text-white transition hover:bg-[#2F6690]"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>
```
