<script setup>
import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import DeleteUserForm from './Partials/DeleteUserForm.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
})
</script>

<template>
    <Head title="Settings" />

    <StagiaireLayout>
        <div class="bg-[#F4F7F9] px-5 py-5 lg:px-7">

            <!-- PAGE HEADER -->
            <div
                class="mb-5 overflow-hidden rounded-2xl
                       bg-gradient-to-r from-[#16425B]
                       via-[#2F6690] to-[#3A7CA5]
                       shadow-sm"
            >
                <div class="px-6 py-5 sm:px-7">
                    <div class="flex items-center gap-4">

                        <!-- ICON -->
                        <div
                            class="flex h-11 w-11 shrink-0
                                   items-center justify-center
                                   rounded-xl bg-white/10
                                   ring-1 ring-white/20"
                        >
                            <svg
                                class="h-5.5 w-5.5 text-white"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <circle cx="12" cy="8" r="3" />
                                <path
                                    d="M5.5 20a6.5 6.5 0 0 1 13 0"
                                />
                            </svg>
                        </div>

                        <!-- TITLE -->
                        <div>
                            <h1
                                class="text-xl font-bold
                                       tracking-tight text-white
                                       sm:text-2xl"
                            >
                                Settings
                            </h1>

                            <p
                                class="mt-1 text-sm text-white/70"
                            >
                                Manage your account information,
                                password and security settings.
                            </p>
                        </div>

                    </div>
                </div>
            </div>


            <!-- CONTENT -->
            <div class="space-y-4">

                <!-- PROFILE INFORMATION -->
                <section
                    class="overflow-hidden rounded-2xl
                           border border-slate-200
                           bg-white shadow-sm"
                >
                    <!-- SECTION HEADER -->
                    <div
                        class="border-b border-slate-100
                               bg-[#F8FAFB]
                               px-6 py-4 sm:px-7"
                    >
                        <h2
                            class="text-base font-bold
                                   text-[#16425B]"
                        >
                            Profile Information
                        </h2>

                        <p
                            class="mt-1 text-xs
                                   text-slate-500"
                        >
                            Update your name and email address.
                        </p>
                    </div>

                    <!-- FORM -->
                    <div class="px-6 py-5 sm:px-7">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="w-full"
                        />
                    </div>
                </section>


                <!-- PASSWORD -->
                <section
                    class="overflow-hidden rounded-2xl
                           border border-slate-200
                           bg-white shadow-sm"
                >
                    <!-- SECTION HEADER -->
                    <div
                        class="border-b border-slate-100
                               bg-[#F8FAFB]
                               px-6 py-4 sm:px-7"
                    >
                        <h2
                            class="text-base font-bold
                                   text-[#16425B]"
                        >
                            Update Password
                        </h2>

                        <p
                            class="mt-1 text-xs
                                   text-slate-500"
                        >
                            Make sure your account is using a
                            strong and secure password.
                        </p>
                    </div>

                    <!-- FORM -->
                    <div class="px-6 py-5 sm:px-7">
                        <UpdatePasswordForm
                            class="w-full"
                        />
                    </div>
                </section>


                <!-- DELETE ACCOUNT -->
                <section
                    class="overflow-hidden rounded-2xl
                           border border-red-100
                           bg-white shadow-sm"
                >
                    <!-- SECTION HEADER -->
                    <div
                        class="border-b border-red-100
                               bg-red-50/50
                               px-6 py-4 sm:px-7"
                    >
                        <h2
                            class="text-base font-bold
                                   text-red-700"
                        >
                            Delete Account
                        </h2>

                        <p
                            class="mt-1 text-xs
                                   text-red-600/70"
                        >
                            Permanently delete your account
                            and all associated data.
                        </p>
                    </div>

                    <!-- FORM -->
                    <div class="px-6 py-5 sm:px-7">
                        <DeleteUserForm
                            class="w-full"
                        />
                    </div>
                </section>

            </div>
        </div>
    </StagiaireLayout>
</template>