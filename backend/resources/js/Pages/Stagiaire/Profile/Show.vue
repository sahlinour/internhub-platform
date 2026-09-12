<script setup>
import { Head, Link } from '@inertiajs/vue3'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'

import ProfileHeader from '@/Components/Stagiaire/Profile/ProfileHeader.vue'
import PersonalInformation from '@/Components/Stagiaire/Profile/PersonalInformation.vue'
import AcademicInformation from '@/Components/Stagiaire/Profile/AcademicInformation.vue'
import ContactInformation from '@/Components/Stagiaire/Profile/ContactInformation.vue'
import ProfileActions from '@/Components/Stagiaire/Profile/ProfileActions.vue'

defineProps({
    stagiaire: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <Head title="Profile" />

    <StagiaireLayout>

        <!-- Page -->
        <div class="bg-[#F4F7F9] py-8 sm:py-10">

            <!-- Container -->
            <div
                class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8"
            >

                <!-- Header -->
                <div>
                    <h1
                        class="text-2xl font-semibold leading-tight text-[#16425B]"
                    >
                        Profile
                    </h1>

                    <p class="mt-1 text-sm text-[#64748B]">
                        View your personal, academic and professional
                        information.
                    </p>
                </div>

                <!-- Profile header -->
                <div
                    class="rounded-lg bg-white p-4 shadow sm:p-8"
                >
                    <ProfileHeader
                        :stagiaire="stagiaire"
                    />
                </div>

                <!-- Personal information -->
                <div
                    class="rounded-lg bg-white p-4 shadow sm:p-8"
                >
                    <PersonalInformation
                        :stagiaire="stagiaire"
                    />
                </div>

                <!-- Academic information -->
                <div
                    class="rounded-lg bg-white p-4 shadow sm:p-8"
                >
                    <AcademicInformation
                        :stagiaire="stagiaire"
                    />
                </div>

                <!-- Contact information -->
                <div
                    class="rounded-lg bg-white p-4 shadow sm:p-8"
                >
                    <ContactInformation
                        :stagiaire="stagiaire"
                    />
                </div>

                <!-- Actions -->
                <div
                    class="rounded-lg bg-white p-4 shadow sm:p-8"
                >
                    <ProfileActions />
                </div>

            </div>
        </div>

    </StagiaireLayout>
</template>
