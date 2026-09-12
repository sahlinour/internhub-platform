<script setup>
import { computed } from 'vue'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },

    stagiaire: {
        type: Object,
        default: null,
    },

    personalInfo: {
        type: Object,
        default: () => ({}),
    },

    cv: {
        type: [Object, File, null],
        default: null,
    },

    coverLetter: {
        type: String,
        default: '',
    },
})

/*
|--------------------------------------------------------------------------
| Internship
|--------------------------------------------------------------------------
*/

const companyName = computed(() => {
    return (
        props.offre?.entreprise?.user?.nom_complet ||
        props.offre?.entreprise?.user?.name ||
        'Entreprise'
    )
})

/*
|--------------------------------------------------------------------------
| Personal Information
|--------------------------------------------------------------------------
*/

const fullName = computed(() => {
    return props.personalInfo?.nom_complet || ''
})

const email = computed(() => {
    return props.personalInfo?.email || ''
})

const telephone = computed(() => {
    return props.personalInfo?.telephone || ''
})

const ville = computed(() => {
    return props.personalInfo?.ville || ''
})

const university = computed(() => {
    return props.personalInfo?.universite || ''
})

const filiere = computed(() => {
    return props.personalInfo?.filiere || ''
})

const niveau = computed(() => {
    return props.personalInfo?.niveau || ''
})

const dateNaissance = computed(() => {
    return props.personalInfo?.date_naissance || ''
})

const linkedin = computed(() => {
    return props.personalInfo?.linkedin_url || ''
})

const portfolio = computed(() => {
    return props.personalInfo?.portfolio_url || ''
})

/*
|--------------------------------------------------------------------------
| Resume
|--------------------------------------------------------------------------
*/

const currentCv = computed(() => {
    if (props.cv?.name) {
        return props.cv.name
    }

    if (props.stagiaire?.stagiaire?.cv_url) {
        return props.stagiaire.stagiaire.cv_url.split('/').pop()
    }

    return ''
})
</script>

<template>
    <section class="space-y-5">

        <!-- Header -->
        <div
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
        >
            <h2 class="text-xl font-bold text-slate-900">
                Review your application
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Check all your information before submitting your application.
            </p>
        </div>

        <!-- Internship -->
        <div
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
        >
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-bold text-slate-900">
                    Internship
                </h3>

                <span
                    class="rounded-full bg-[#2F6690]/10 px-3 py-1 text-xs font-semibold text-[#2F6690]"
                >
                    Selected
                </span>
            </div>

            <p class="font-semibold text-slate-800">
                {{ offre.titre }}
            </p>

            <p class="mt-1 text-sm text-slate-500">
                {{ companyName }}
            </p>
        </div>

        <!-- Personal Information -->
        <div
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
        >
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-bold text-slate-900">
                    Personal Information
                </h3>

                <span class="text-xs font-medium text-green-600">
                    Completed
                </span>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">

                <!-- Full Name -->
                <div>
                    <p class="text-xs text-slate-400">
                        Full Name
                    </p>

                    <p
                        class="mt-1 min-h-[20px] text-sm font-medium text-slate-700"
                    >
                        {{ fullName }}
                    </p>
                </div>

                <!-- Email -->
                <div>
                    <p class="text-xs text-slate-400">
                        Email
                    </p>

                    <p
                        class="mt-1 min-h-[20px] break-all text-sm font-medium text-slate-700"
                    >
                        {{ email }}
                    </p>
                </div>

                <!-- Phone -->
                <div>
                    <p class="text-xs text-slate-400">
                        Phone
                    </p>

                    <p
                        class="mt-1 min-h-[20px] text-sm font-medium text-slate-700"
                    >
                        {{ telephone }}
                    </p>
                </div>

                <!-- City -->
                <div>
                    <p class="text-xs text-slate-400">
                        City
                    </p>

                    <p
                        class="mt-1 min-h-[20px] text-sm font-medium text-slate-700"
                    >
                        {{ ville }}
                    </p>
                </div>

                <!-- University -->
                <div>
                    <p class="text-xs text-slate-400">
                        University
                    </p>

                    <p
                        class="mt-1 min-h-[20px] text-sm font-medium text-slate-700"
                    >
                        {{ university }}
                    </p>
                </div>

                <!-- Field of Study -->
                <div>
                    <p class="text-xs text-slate-400">
                        Field of Study
                    </p>

                    <p
                        class="mt-1 min-h-[20px] text-sm font-medium text-slate-700"
                    >
                        {{ filiere }}
                    </p>
                </div>

                <!-- Level -->
                <div>
                    <p class="text-xs text-slate-400">
                        Level
                    </p>

                    <p
                        class="mt-1 min-h-[20px] text-sm font-medium text-slate-700"
                    >
                        {{ niveau }}
                    </p>
                </div>

                <!-- Date of Birth -->
                <div>
                    <p class="text-xs text-slate-400">
                        Date of Birth
                    </p>

                    <p
                        class="mt-1 min-h-[20px] text-sm font-medium text-slate-700"
                    >
                        {{ dateNaissance }}
                    </p>
                </div>

                <!-- LinkedIn -->
                <div>
                    <p class="text-xs text-slate-400">
                        LinkedIn
                    </p>

                    <p
                        class="mt-1 min-h-[20px] break-all text-sm font-medium text-[#2F6690]"
                    >
                        {{ linkedin }}
                    </p>
                </div>

                <!-- Portfolio -->
                <div>
                    <p class="text-xs text-slate-400">
                        Portfolio
                    </p>

                    <p
                        class="mt-1 min-h-[20px] break-all text-sm font-medium text-[#2F6690]"
                    >
                        {{ portfolio }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Resume -->
        <div
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
        >
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-bold text-slate-900">
                    Resume
                </h3>

                <span
                    class="text-xs font-medium"
                    :class="
                        currentCv
                            ? 'text-green-600'
                            : 'text-slate-400'
                    "
                >
                    {{ currentCv ? 'Completed' : 'Optional' }}
                </span>
            </div>

            <div
                class="flex items-center gap-3 rounded-xl bg-slate-50 p-4"
            >
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#2F6690]/10 text-[#2F6690]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 3h7l5 5v13H7V3z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 3v6h5"
                        />
                    </svg>
                </div>

                <p
                    class="truncate text-sm font-medium"
                    :class="
                        currentCv
                            ? 'text-slate-700'
                            : 'text-slate-400'
                    "
                >
                    {{ currentCv }}
                </p>
            </div>
        </div>

        <!-- Cover Letter -->
        <div
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
        >
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-bold text-slate-900">
                    Cover Letter
                </h3>

                <span
                    class="text-xs font-medium"
                    :class="
                        coverLetter
                            ? 'text-green-600'
                            : 'text-slate-400'
                    "
                >
                    {{ coverLetter ? 'Completed' : 'Optional' }}
                </span>
            </div>

            <div
                v-if="coverLetter"
                class="rounded-xl bg-slate-50 p-4"
            >
                <p
                    class="whitespace-pre-line text-sm leading-6 text-slate-600"
                >
                    {{ coverLetter }}
                </p>
            </div>

            <div
                v-else
                class="rounded-xl bg-slate-50 p-4"
            >
                <p class="text-sm italic text-slate-400">
                    No cover letter provided.
                </p>
            </div>
        </div>

        <!-- Warning -->
        <div
            class="rounded-xl border border-amber-200 bg-amber-50 p-4"
        >
            <div class="flex gap-3">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0 text-amber-500"
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

                <p class="text-sm leading-6 text-amber-700">
                    Please make sure all information is correct. Once submitted,
                    your application will be sent to the company.
                </p>
            </div>
        </div>

    </section>
</template>
