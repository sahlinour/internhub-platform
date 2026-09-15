<script setup>
import { computed } from 'vue'

const props = defineProps({
    offre: { type: Object, required: true },
    stagiaire: { type: Object, default: null },
    personalInfo: { type: Object, default: () => ({}) },
    cv: { type: [File, null], default: null },
    coverLetter: { type: String, default: '' },
})
const companyName = computed(() =>
    props.offre?.entreprise?.user?.nom_complet ||
    props.offre?.entreprise?.user?.name ||
    'Company not specified'
)
const currentCv = computed(() =>
    props.cv?.name ||
    props.stagiaire?.stagiaire?.cv_url?.split('/').pop() ||
    ''
)
const personalFields = [
    ['nom_complet', 'Full Name'],
    ['email', 'Email'],
    ['telephone', 'Phone'],
    ['ville', 'City'],
    ['universite', 'University'],
    ['filiere', 'Field of Study'],
    ['niveau', 'Level'],
    ['date_naissance', 'Date of Birth'],
    ['linkedin_url', 'LinkedIn'],
    ['portfolio_url', 'Portfolio'],
]
</script>

<template>
    <section class="space-y-5">
        <!-- Header -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-lg font-bold text-[#16425B]">Review your application</h2>
            <p class="mt-1 text-xs text-slate-500">
                Check all your information before submitting your application.
            </p>
        </div>

        <!-- Internship -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-bold text-[#16425B]">Internship</h3>
                <span class="rounded-full bg-[#E8F1F5] px-3 py-1 text-[10px] font-semibold text-[#3A7CA5]">
                    Selected
                </span>
            </div>

            <p class="text-sm font-semibold text-slate-800">{{ offre.titre }}</p>
            <p class="mt-1 text-xs text-slate-500">{{ companyName }}</p>
        </div>

        <!-- Personal Information -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-bold text-[#16425B]">Personal Information</h3>
                <span class="text-[10px] font-semibold text-[#3A7CA5]">Completed</span>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div v-for="[field, label] in personalFields" :key="field">
                    <p class="text-[10px] font-medium uppercase tracking-wide text-slate-400">
                        {{ label }}
                    </p>

                    <p
                        class="mt-1 min-h-[20px] break-all text-sm font-medium"
                        :class="['linkedin_url', 'portfolio_url'].includes(field)
                            ? 'text-[#3A7CA5]'
                            : 'text-slate-700'"
                    >
                        {{ personalInfo[field] || '—' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Resume -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-bold text-[#16425B]">Resume</h3>
                <span
                    class="text-[10px] font-semibold"
                    :class="currentCv ? 'text-[#3A7CA5]' : 'text-slate-400'"
                >
                    {{ currentCv ? 'Completed' : 'Optional' }}
                </span>
            </div>

            <div class="flex items-center gap-3 rounded-xl border border-[#81C3D7]/40 bg-[#E8F1F5] p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-[#3A7CA5] shadow-sm">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l5 5v13H7V3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v6h5" />
                    </svg>
                </div>

                <p
                    class="truncate text-sm font-semibold"
                    :class="currentCv ? 'text-[#16425B]' : 'text-slate-400'"
                >
                    {{ currentCv || 'No resume provided' }}
                </p>
            </div>
        </div>

        <!-- Cover Letter -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-bold text-[#16425B]">Cover Letter</h3>
                <span
                    class="text-[10px] font-semibold"
                    :class="coverLetter ? 'text-[#3A7CA5]' : 'text-slate-400'"
                >
                    {{ coverLetter ? 'Completed' : 'Optional' }}
                </span>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p
                    v-if="coverLetter"
                    class="whitespace-pre-line text-sm leading-6 text-slate-600"
                >
                    {{ coverLetter }}
                </p>

                <p v-else class="text-xs italic text-slate-400">
                    No cover letter provided.
                </p>
            </div>
        </div>

        <!-- Warning -->
        <div class="rounded-xl border border-[#81C3D7]/50 bg-[#E8F1F5] p-4">
            <div class="flex gap-3">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0 text-[#3A7CA5]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M10.29 3.86l-7.82 13.5A2 2 0 004.2 20.5h15.6a2 2 0 001.73-3.14l-7.82-13.5a2 2 0 00-3.42 0z"
                    />
                </svg>

                <p class="text-xs leading-5 text-[#2F6690]">
                    Please make sure all information is correct. Once submitted,
                    your application will be sent to the company.
                </p>
            </div>
        </div>
    </section>
</template>
