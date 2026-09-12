<script setup>
import { computed, ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import ApplyStepper from '@/Components/Stagiaire/Offres/ApplyInternship/ApplyStepper.vue'
import JobSummaryCard from '@/Components/Stagiaire/Offres/ApplyInternship/JobSummaryCard.vue'
import PersonalInfoStep from '@/Components/Stagiaire/Offres/ApplyInternship/PersonalInfoStep.vue'
import ResumeStep from '@/Components/Stagiaire/Offres/ApplyInternship/ResumeStep.vue'
import CoverLetterStep from '@/Components/Stagiaire/Offres/ApplyInternship/CoverLetterStep.vue'
import ReviewStep from '@/Components/Stagiaire/Offres/ApplyInternship/ReviewStep.vue'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },

    stagiaire: {
        type: Object,
        default: null,
    },
})

const currentStep = ref(1)

/*
|--------------------------------------------------------------------------
| Application form
|--------------------------------------------------------------------------
*/

const form = useForm({
    personalInfo: {
        nom_complet: props.stagiaire?.nom_complet || '',
        email: props.stagiaire?.email || '',
        telephone: props.stagiaire?.telephone || '',
        ville: props.stagiaire?.ville?.nom || '',
        universite: props.stagiaire?.stagiaire?.universite || '',
        filiere: props.stagiaire?.stagiaire?.filiere || '',
        niveau: props.stagiaire?.stagiaire?.niveau || '',
        date_naissance: props.stagiaire?.stagiaire?.date_naissance || '',
        linkedin_url: props.stagiaire?.stagiaire?.linkedin_url || '',
        portfolio_url: props.stagiaire?.stagiaire?.portfolio_url || '',
    },

    lettre_de_motivation: '',
    cv: null,
    piece_jointe: null,
})

/*
|--------------------------------------------------------------------------
| Steps
|--------------------------------------------------------------------------
*/

const isFirstStep = computed(() => currentStep.value === 1)

const isLastStep = computed(() => currentStep.value === 4)

const nextStep = () => {
    if (currentStep.value < 4) {
        currentStep.value++

        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        })
    }
}

const previousStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--

        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        })
    }
}

/*
|--------------------------------------------------------------------------
| CV
|--------------------------------------------------------------------------
*/

const updateCv = (file) => {
    form.cv = file
}

/*
|--------------------------------------------------------------------------
| Submit
|--------------------------------------------------------------------------
*/

const submitApplication = () => {
    form.post(
        route(
            'stagiaire.candidatures.store',
            props.offre.id
        ),
        {
            forceFormData: true,
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <StagiaireLayout>
        <div class="min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-5xl">

                <!-- Back -->
                <Link
                    :href="route('offres.show', offre.id)"
                    class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-[#2F6690]"
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
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>

                    Back to internship
                </Link>

                <!-- Header / Job -->
                <JobSummaryCard :offre="offre" />

                <!-- Stepper -->
                <ApplyStepper :current-step="currentStep" />

                <!-- Step 1 -->
                <PersonalInfoStep
                    v-if="currentStep === 1"
                    v-model="form.personalInfo"
                />

                <!-- Step 2 -->
                <ResumeStep
                    v-else-if="currentStep === 2"
                    :stagiaire="stagiaire"
                    :model-value="form.cv"
                    :error="form.errors.cv"
                    @update:model-value="updateCv"
                />

                <!-- Step 3 -->
                <CoverLetterStep
                    v-else-if="currentStep === 3"
                    v-model="form.lettre_de_motivation"
                    :error="form.errors.lettre_de_motivation"
                />

                <!-- Step 4 -->
                <ReviewStep
                    v-else-if="currentStep === 4"
                    :offre="offre"
                    :stagiaire="stagiaire"
                    :personal-info="form.personalInfo"
                    :cv="form.cv"
                    :cover-letter="form.lettre_de_motivation"
                />

                <!-- Navigation -->
                <div
                    class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between"
                >
                    <!-- Left -->
                    <div>
                        <!-- Cancel -->
                        <Link
                            v-if="isFirstStep"
                            :href="route('offres.show', offre.id)"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50"
                        >
                            Cancel
                        </Link>

                        <!-- Previous -->
                        <button
                            v-else
                            type="button"
                            @click="previousStep"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50"
                        >
                            Previous
                        </button>
                    </div>

                    <!-- Right -->
                    <button
                        v-if="!isLastStep"
                        type="button"
                        @click="nextStep"
                        class="inline-flex items-center justify-center rounded-xl bg-[#2F6690] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#16425B]"
                    >
                        Continue

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-2 h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </button>

                    <!-- Submit -->
                    <button
                        v-else
                        type="button"
                        :disabled="form.processing"
                        @click="submitApplication"
                        class="inline-flex items-center justify-center rounded-xl bg-[#2F6690] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#16425B] disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <svg
                            v-if="!form.processing"
                            xmlns="http://www.w3.org/2000/svg"
                            class="mr-2 h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        {{ form.processing ? 'Submitting...' : 'Submit Application' }}
                    </button>
                </div>

            </div>
        </div>
    </StagiaireLayout>
</template>
