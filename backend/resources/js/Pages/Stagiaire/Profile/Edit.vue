```vue
<script setup>
import { Head, useForm } from '@inertiajs/vue3'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'

import ProfileEditHeader from '@/Components/Stagiaire/Profile/ProfileEditHeader.vue'
import PersonalInformationForm from '@/Components/Stagiaire/Profile/PersonalInformationForm.vue'
import AcademicInformationForm from '@/Components/Stagiaire/Profile/AcademicInformationForm.vue'
import ContactInformationForm from '@/Components/Stagiaire/Profile/ContactInformationForm.vue'
import ProfileEditActions from '@/Components/Stagiaire/Profile/ProfileEditActions.vue'

const props = defineProps({
    stagiaire: {
        type: Object,
        required: true,
    },

    villes: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    nom_complet: props.stagiaire?.nom_complet || '',
    email: props.stagiaire?.email || '',
    telephone: props.stagiaire?.telephone || '',
    ville_id: props.stagiaire?.ville_id || '',

    universite: props.stagiaire?.stagiaire?.universite || '',
    filiere: props.stagiaire?.stagiaire?.filiere || '',
    niveau: props.stagiaire?.stagiaire?.niveau || '',
    date_naissance: props.stagiaire?.stagiaire?.date_naissance || '',

    linkedin_url: props.stagiaire?.stagiaire?.linkedin_url || '',
    portfolio_url: props.stagiaire?.stagiaire?.portfolio_url || '',
    statut_stage: props.stagiaire?.stagiaire?.statut_stage || '',

    photo: null,
    cv: null,
})

const handlePhoto = (event) => {
    form.photo = event.target.files[0] || null
}

const handleCv = (event) => {
    form.cv = event.target.files[0] || null
}

const submit = () => {
    form.put(route('stagiaire.profile.update'), {
        forceFormData: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Edit Profile" />

    <StagiaireLayout>
        <main class="min-h-screen bg-[#F4F7F9]">

            <div
                class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8"
            >

                <!-- Header + Photo -->
                <ProfileEditHeader
                    :stagiaire="stagiaire"
                    :errors="form.errors"
                    @photo-change="handlePhoto"
                />

                <form
                    @submit.prevent="submit"
                    class="space-y-5"
                >

                    <!-- Personal Information -->
                    <PersonalInformationForm
                        v-model="form"
                        :errors="form.errors"
                    />

                    <!-- Academic Information -->
                    <AcademicInformationForm
                        v-model="form"
                        :errors="form.errors"
                    />

                    <!-- Contact & Professional Information -->
                    <ContactInformationForm
                        v-model="form"
                        :villes="villes"
                        :errors="form.errors"
                        :current-cv="stagiaire.stagiaire?.cv_url"
                        @cv-change="handleCv"
                    />

                    <!-- Actions -->
                    <ProfileEditActions
                        :processing="form.processing"
                    />

                </form>

            </div>

        </main>
    </StagiaireLayout>
</template>
```
