<script setup>
import { Head } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import CVUploadForm from '@/Components/Stagiaire/CV/CVUploadForm.vue'

const form = useForm({
    nom: '',
    version: '1.0',
    fichier: null,
})

const submit = () => {
    form.post(route('stagiaire.cv.store'))
}
</script>

<template>
    <Head title="Upload CV" />

    <StagiaireLayout>
        <div class="min-h-screen bg-[#f4f7fb]">
            <div class="mx-auto w-full max-w-2xl px-4 py-6 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-[22px] font-bold text-[#16425B]">
                        Upload New CV
                    </h1>
                    <p class="mt-1 text-[12px] text-slate-500">
                        Upload your professional CV to make it easily accessible for internship applications.
                    </p>
                </div>

                <!-- Upload Form -->
                <CVUploadForm
                    :form="form"
                    @submit="submit"
                />

            </div>
        </div>
    </StagiaireLayout>
</template>
