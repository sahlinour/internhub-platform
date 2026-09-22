<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <section
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
    >
        <div class="mb-5">
            <h3 class="font-semibold text-[#16425B]">
                Profile Actions
            </h3>

            <p class="mt-1 text-xs text-[#64748B]">
                Manage your profile and account
            </p>
        </div>

        <div class="space-y-3">

            <!-- Edit profile -->
            <Link
                :href="route('stagiaire.profile.edit')"
                class="flex w-full items-center justify-between rounded-xl border border-slate-200 bg-white p-3 transition hover:border-[#81C3D7] hover:bg-[#F8FAFB]"
            >
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#2F6690]"
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
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"
                            />
                        </svg>
                    </div>

                    <div class="text-left">
                        <p class="text-sm font-semibold text-slate-800">
                            Edit Profile
                        </p>

                        <p class="text-xs text-[#64748B]">
                            Update your personal information
                        </p>
                    </div>
                </div>

                <span class="text-[#64748B]">
                    →
                </span>
            </Link>

            <!-- Password -->
            <Link
                :href="route('stagiaire.profile.edit')"
                class="flex w-full items-center justify-between rounded-xl border border-slate-200 bg-white p-3 transition hover:border-[#81C3D7] hover:bg-[#F8FAFB]"
            >
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#2F6690]"
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
                                d="M16.5 10.5V7.875a4.5 4.5 0 10-9 0V10.5m-1.5 0h12a1.5 1.5 0 011.5 1.5v8.25a1.5 1.5 0 01-1.5 1.5h-12a1.5 1.5 0 01-1.5-1.5V12a1.5 1.5 0 011.5-1.5z"
                            />
                        </svg>
                    </div>

                    <div class="text-left">
                        <p class="text-sm font-semibold text-slate-800">
                            Password & Security
                        </p>

                        <p class="text-xs text-[#64748B]">
                            Change your account password
                        </p>
                    </div>
                </div>

                <span class="text-[#64748B]">
                    →
                </span>
            </Link>
        </div>
    </section>
</template>
